<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$role = Role::findById(1);
        // return auth()->user()->removeRole($role);
        //auth()->user()->assignRole('Admin');

        // $role = Role::create(['name' => 'User']);
        // auth()->user()->assignRole('Staff Desa');
        // $permission = Permission::create(['name' => 'update post']);

        // $permission->assignRole($role);

        // $role = Role::findById(1);
        // $permission = Permission::findById(1);

        // $role->revokePermissionTo($permission);

        // auth()->user()->givePermissionTo('edit post');
        // return auth()->user()->permissions;
        // //mengambil seluruh data
        // $all = TemplateSurat::all();
        // //menjumlahkan seluruh isi dari table total
        // $sumall = $all->sum('total');
        // //Menjumlahkan seluruh data yg ada
        // $data = $all->count();
        // $currentMonth = date('m');
        // //mengambil data berdasarkan bulan ini
        // $month = TemplateSurat::whereRaw('MONTH(created_at) = ?', [$currentMonth])->get();
        // //menjumlahkan seluruh isi dari table total berdasarkan bulan ini
        // $sum = $month->sum('total');
        // //menghitung jumlah data yang ada pada bulan ini
        // $countmonth = $month->count();

        // $post = TemplateSurat::orderBy('created_at', 'DESC')->limit(5)->get();
        // $sumpost = $post->sum('total');
        return redirect('/surat/');
        // return view('home.dashboard', compact('month', 'countmonth', 'data', 'sum', 'sumall', 'post', 'sumpost'));

    }

    public function edit(User $id)
    {
        $data = Auth::user();
        $listAgama = ['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Budha', 'Konghucu'];
        $listJenisKelamin = ['Laki-laki', 'Perempuann'];
        $role = Auth::user()->roles->pluck('name')[0];
        return view('home.edit_profile', compact('data', 'role', 'listAgama', 'listJenisKelamin'));
    }

    public function update(Request $request, $id)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'sometimes|nullable',
            'role_id' => 'sometimes|nullable',
        ]);

        if ($request->password != null) {
            $data = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ];
        } else {
            unset($data['password']);
        }

        if (!empty($request->photo)) {
            $path = public_path('/img/user/');
            $originalImage = $request->photo;
            $Image = Image::make($originalImage);
            $Image->resize(540, 360);
            $fileName = time() . $originalImage->getClientOriginalName();
            $Image->save($path . $fileName);
            $data['photo'] = $fileName;

        }

        $user = User::findOrFail($id);

        if ($request->role_id) {
            $role = Role::where('id', $request->role_id)->first();
            $user->syncRoles($role->name);
        }

        User::where('id', $id)->update($data);
        return redirect('/home');
    }
    public function filter()
    {

        $currentMonth = date('m');
        //mengambil data berdasarkan bulan ini
        $month = Reimbursement::whereRaw('MONTH(date) = ?', [$currentMonth])->get();
        //menjumlahkan seluruh isi dari table total berdasarkan bulan ini
        $sum = $month->sum('total');
        //menghitung jumlah data yang ada pada bulan ini
        $countmonth = $month->count();

        return view('reimbursement.filter_reimburse', compact('month', 'sum', 'countmonth'));
    }
}
