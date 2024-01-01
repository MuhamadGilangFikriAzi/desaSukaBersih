<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SuratDetail;
use App\Models\TemplateSurat;
use DB;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class SuratController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $list = Surat::query();
        $filter = [
            'id' => '',
            'template_surat_id' => '',
            'created_at' => '',
        ];
        $role = Auth::user()->roles->pluck('name')[0];
        if ($role == "User") {
            $list = $list->where('user_id', '=', Auth::user()->id);
        }

        if ($request->id) {
            $list = $list->where('id', '=', $request->id);
            $filter['id'] = $request->id;
        }
        if ($request->template_surat_id != "") {
            $list = $list->where('template_surat_id', '=', $request->template_surat_id);
            $filter['template_surat_id'] = $request->template_surat_id;
        }
        if ($request->created_at) {
            $list = $list->whereDate('created_at', $request->created_at);
            $filter['created_at'] = $request->created_at;
        }

        $list = $list->with(['template_surat'])->paginate('10');
        $listTemplateSurat = TemplateSurat::all();
        $count = $list->count();
        return view('surat/index', compact('list', 'listTemplateSurat', 'count', 'filter'));
    }

    public function create()
    {
        $listTemplateSurat = TemplateSurat::all();

        return view('surat/create', compact('listTemplateSurat'));
    }

    public function onChangeTypeSurat(Request $request)
    {
        $details = TemplateSurat::find($request->id);
        return response()->json(['data' => [
            'details' => $details->TemplateSuratDetails()->get(),
            'surat' => $details,
        ]]);
    }

    public function getDataOnPrint(Request $request)
    {
        $data = Surat::find($request->id);

        $bodySurat = $data->body_surat;
        $document = [];

        foreach ($data->detail()->get() as $value) {
            if ($value->input_type == "text") {
                $bodySurat = str_replace("[" . $value->tag . "]", $value->value, $bodySurat);
            }

            if ($value->input_type == "date") {
                $bodySurat = str_replace("[" . $value->tag . "]", date("d F Y", strtotime($value->value)), $bodySurat);
            }

            if ($value->input_type == "document") {
                array_push($document, $value);
            }
        }

        $TemplateSurat = TemplateSurat::find($data->template_surat_id);
        $year = date("Y-m-d");
        $counterCode = DB::select("SELECT COUNT(*) as total FROM surat
        WHERE YEAR(printed_at) = YEAR('" . $year . "')
        AND template_surat_id = " . $data->template_surat_id)[0]->total;
        $arrCodeSurat = [$TemplateSurat->code_surat, $counterCode + 1];
        $codeSurat = implode(" / ", $arrCodeSurat);

        return response()->json(['data' => [
            'bodySurat' => $bodySurat,
            'document' => $document,
            'codeSurat' => $codeSurat,
            'jenisSurat' => $TemplateSurat->type_surat,
        ]]);
    }

    public function store(Request $request)
    {
        $message = [
            'template_surat_id.required' => '*Tipe Surat Wajib Diisi',
        ];

        $arrValidate = [
            'template_surat_id' => 'required',
        ];
        foreach ($request->detail as $key => $value) {
            if ($value['input_type'] != 'dokumen') {
                $message['detail.' . $key . '.value'] = '*' . $value['label'] . ' Wajib Diisi';
                $arrValidate['detail.' . $key . '.value'] = 'required';
            }
        }

        $this->validate($request, $arrValidate, $message);

        $templateSurat = TemplateSurat::find($request->template_surat_id);
        $reqSurat = [
            'template_surat_id' => $templateSurat->id,
            'body_surat' => $templateSurat->body_surat,
            'user_id' => Auth::id(),
        ];

        $respSurat = Surat::create($reqSurat);
        foreach ($request->detail as $key => $value) {
            $reqDetail = $value;
            $reqDetail['surat_id'] = $respSurat->id;
            if ($value['input_type'] == 'document' && $request->hasfile('detail.' . $key . '.value')) {
                $originalFile = $request->file('detail.' . $key . '.value');
                $file = $originalFile;
                $fileName = $reqDetail['surat_id'] . '-' . $value['tag'] . $originalFile->getClientOriginalName();
                // dd($fileName);
                Storage::disk('document')->putFileAs('archive', $file, $fileName);
                $reqDetail['value'] = $fileName;
            }

            $respSuratDetail = SuratDetail::create($reqDetail);
        }

        return redirect('/surat/');
    }

    public function generateSuratPdf(Request $request)
    {
        $surat = Surat::find($request->id);
        $data = [
            'jenisSurat' => $request->jenisSurat,
            'codeSurat' => $request->codeSurat,
            'bodySurat' => $request->bodySurat,
        ];

        $dataUpdate = [];
        $dataUpdate['id'] = $request->id;
        $dataUpdate['printed_at'] = date('Y-m-d H:i:s');
        $dataUpdate['last_admin_print'] = Auth::id();
        $surat->update($dataUpdate);

        $pdf = PDF::loadView('surat/generatePDF', $data);
        $pdf->setPaper("a4", "potrait");

        return $pdf->download(str_replace(" ", "", $request->codeSurat) . '-' . date('Y-m-d H:i') . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $surat = Surat::find($id);
        $suratDetail = $surat->detail()->get();
        $listTemplateSurat = TemplateSurat::all();

        return view('surat/edit', compact('surat', 'suratDetail', 'listTemplateSurat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->except('_token', 'submit', 'detail');
        $dataSuratDetail = $request->detail;

        foreach ($dataSuratDetail as $key => $value) {
            $reqDetail = $value;
            $reqDetail['surat_id'] = $request->id;

            if ($value['input_type'] == 'document' && $request->hasfile('detail.' . $key . '.value')) {
                $originalFile = $request->file('detail.' . $key . '.value');
                $file = $originalFile;
                $fileName = $reqDetail['surat_id'] . '-' . $value['tag'] . $originalFile->getClientOriginalName();
                Storage::disk('document')->putFileAs('archive', $file, $fileName);
                $reqDetail['value'] = $fileName;
            }
            $suratDetail = SuratDetail::findOrFail($reqDetail['id']);
            $suratDetail->update($reqDetail);
        }

        return redirect('/surat/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}