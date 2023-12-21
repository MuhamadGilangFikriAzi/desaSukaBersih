<?php

namespace App\Http\Controllers;

use App\Models\TemplateSurat;
use App\Models\TemplateSuratDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateSuratController extends Controller
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
        $list = TemplateSurat::query();
        $filter = [
            'id' => '',
            'type_surat' => '',
        ];
        //dd($request->id);
        if ($request->id) {
            $list = $list->where('id', '=', $request->id);
            $filter['id'] = $request->id;
        }
        if ($request->type_surat) {
            $list = $list->where('type_surat', 'like', '%' . $request->type_surat . '%');
            $filter['type_surat'] = $request->template_surat_id;
        }

        $list = $list->paginate('10');

        $count = TemplateSurat::all()->count();
        return view('templatesurat/index', compact('list', 'count', 'filter'));
    }

    public function create()
    {
        return view('templatesurat/create');
    }

    public function store(Request $request)
    {
        $message = [
            'type_surat.required' => '*Tipe Surat Wajib Diisi',
            'code_surat.required' => '*Code Surat Wajib Diisi',
        ];
        $this->validate($request, [
            'type_surat' => 'required',
            'code_surat' => 'required',
        ], $message);

        $data = $request->except('_token', 'submit', 'TemplateSuratdetail');
        $data['admin_id'] = Auth::id();
        $data['is_active'] = 'Y';
        $TemplateSuratDetail = $request->TemplateSuratdetail;
        $paramData = TemplateSurat::create($data);
        foreach ($TemplateSuratDetail as $detail) {
            $detail["template_surat_id"] = $paramData->id;

            TemplateSuratDetail::create($detail);
        }
        return redirect('/templatesurat/');
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
        $templateSurat = TemplateSurat::find($id);
        $templateSuratDetail = $templateSurat->TemplateSuratDetails()->get();
        // dd($templateSuratDetail);
        return view('templatesurat/edit', compact('templateSurat', 'templateSuratDetail'));
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
