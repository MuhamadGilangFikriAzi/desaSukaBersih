<?php

namespace App\Http\Controllers;

use App\Models\ParameterSurat;
use App\Models\ParameterSuratDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParameterSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $list = ParameterSurat::query();

        if ($request->id) {
            $list = $list->where('id', '=', $request->id);
        }
        if ($request->type) {
            $list = $list->where('type_surat', 'like', '%' . $request->type . '%');
        }

        $list = $list->paginate('10');

        $count = ParameterSurat::all()->count();
        return view('parametersurat/index', compact('list', 'count'));
    }

    public function create()
    {
        return view('parametersurat/create');
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

        $data = $request->except('_token', 'submit', 'parametersuratdetail');
        $data['admin_id'] = Auth::id();
        $data['is_active'] = 'Y';
        $parameterSuratDetail = $request->parametersuratdetail;
        $paramData = ParameterSurat::create($data);
        foreach ($parameterSuratDetail as $detail) {
            $detail["parameter_surat_id"] = $paramData->id;

            ParameterSuratDetail::create($detail);
        }
        return redirect('/parametersurat/');
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
