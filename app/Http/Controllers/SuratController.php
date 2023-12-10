<?php

namespace App\Http\Controllers;

use App\Models\ParameterSurat;
use App\Models\Surat;
use App\Models\SuratDetail;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'parameter_surat_id' => '',
            'created_at' => '',
        ];
        //dd($request->id);
        if ($request->id) {
            $list = $list->where('id', '=', $request->id);
            $filter['id'] = $request->id;
        }
        if ($request->parameter_surat_id != "") {
            $list = $list->where('parameter_surat_id', '=', $request->parameter_surat_id);
            $filter['parameter_surat_id'] = $request->parameter_surat_id;
        }
        if ($request->created_at) {
            $list = $list->whereDate('created_at', $request->created_at);
            $filter['created_at'] = $request->created_at;
        }

        $list = $list->with(['parameter_surat'])->paginate('10');
        $listParameterSurat = ParameterSurat::all();
        $count = $list->count();
        return view('surat/index', compact('list', 'listParameterSurat', 'count', 'filter'));
    }

    public function create()
    {
        $listParameterSurat = ParameterSurat::all();

        return view('surat/create', compact('listParameterSurat'));
    }

    public function onChangeTypeSurat(Request $request)
    {
        $details = ParameterSurat::find($request->id);
        return response()->json(['data' => [
            'details' => $details->ParameterSuratDetails()->get(),
            'surat' => $details,
        ]]);
    }

    public function store(Request $request)
    {
        $message = [
            'parameter_surat_id.required' => '*Tipe Surat Wajib Diisi',
        ];

        $arrValidate = [
            'parameter_surat_id' => 'required',
        ];
        foreach ($request->detail as $key => $value) {
            if ($value['input_type'] != 'dokumen') {
                $message['detail.' . $key . '.value'] = '*' . $value['label'] . ' Wajib Diisi';
                $arrValidate['detail.' . $key . '.value'] = 'required';
            }
        }

        $this->validate($request, $arrValidate, $message);
        //dd(Storage::disk('document_upload')->exists('17022103011. Menganalisis Skalabilitas Perangkat Lunak.pdf'));

        $templateSurat = ParameterSurat::find($request->parameter_surat_id);
        $reqSurat = [
            'parameter_surat_id' => $templateSurat->id,
            'body_surat' => $templateSurat->body_surat,
            'user_id' => Auth::id(),
        ];

        $respSurat = Surat::create($reqSurat);

        //dd($request->hasfile('detail.2.value'));
        //dd($request->detail);
        foreach ($request->detail as $key => $value) {
            $reqDetail = $value;
            $reqDetail['surat_id'] = $respSurat->id;

            if ($value['input_type'] == 'document' && $request->hasfile('detail.' . $key . '.value')) {
                // rill
                $originalFile = $request->file('detail.2.value');
                $file = $originalFile;
                $fileName = $reqDetail['surat_id'] . '-' . $value['tag'] . '-' . $originalFile->getClientOriginalName();
                Storage::disk('document_upload')->putFileAs('archive', $file, $fileName);
                $reqDetail['value'] = $fileName;
            }
            $respSuratDetail = SuratDetail::create($reqDetail);
        }

        return redirect('/surat/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
