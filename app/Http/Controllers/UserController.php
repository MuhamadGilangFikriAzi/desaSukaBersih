<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Spatie\Permission\Models\Role;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $list = User::query();
        $filter = [
            'name' => '',
            'created_at' => '',
        ];

        if ($request->name) {
            $list = $list->where('name', 'like', '%' . $request->name . '%');
            $filter['name'] = $request->id;
        }

        if ($request->created_at) {
            $list = $list->whereDate('created_at', $request->created_at);
            $filter['created_at'] = $request->created_at;
        }
        $data = $list->count();

        $list = $list->orderBy('created_at', 'DESC')->paginate('10');

        return view('user.list', compact('list', 'data', 'filter'));
    }

    public function getDataUserByID(Request $request)
    {
        $data = User::find($request->id);
        return response()->json(['data' => [
            'data' => $data,
            'role' => $data->roles->pluck('name')[0],
        ]]);
    }

    public function giveUserRole(Request $request)
    {
        $data = User::find($request->id);
        $data->roles()->detach();
        $data->assignRole($request->role);
        return response()->json(['data' => "Success"]);
    }

    public function rejectUser(Request $request)
    {
        $data = User::find($request->id);
        $data->note_reject = $request->reason;
        $data->rejected_at = date('Y-m-d H:i:s');
        $data->update();
        return response()->json(['data' => "Success"]);
    }

    public function edit(User $id)
    {
        $data = Auth::user();
        $listAgama = ['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Budha', 'Konghucu'];
        $listJenisKelamin = ['Laki-laki', 'Perempuann'];
        $role = Auth::user()->roles->pluck('name')[0];
        // dd($data);
        return view('user.edit_profile', compact('data', 'role', 'listAgama', 'listJenisKelamin'));
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $data = $request->except('_token', 'submit', 'password', 'repassword', 'ktp');

        $fileKtp = $request->file('ktp');
        if ($request->hasfile('ktp')) {
            $path = public_path('/img/ktp/');

            $originalImage = $fileKtp;
            $Image = Image::make($originalImage);
            $Image->resize(540, 360);
            $fileName = $data['nik'] . "-ktp-." . $originalImage->getClientOriginalExtension();
            if (!file_exists($path)) {
                mkdir($path, 666, true);
            }
            $Image->save($path . $fileName);
            $data['ktp'] = $fileName;
        }

        if ($request->password != null) {
            $data['password'] = bcrypt($request->password);
        }

        $data['rejected_at'] = null;

        // dd($data);
        $user = User::find($id)->update($data);

        return redirect('/surat');
    }
}
