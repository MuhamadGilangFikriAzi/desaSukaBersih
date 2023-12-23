<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = User::query();
        $data = User::count();

        $list = User::paginate('5');

        return view('user.list', compact('list', 'data'));
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
}
