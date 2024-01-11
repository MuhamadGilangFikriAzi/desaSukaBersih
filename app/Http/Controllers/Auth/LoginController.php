<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'nik';
    }

    public function validateUserLogin(Request $request)
    {
        $msg = '';
        if (trim($request->nik) === '' || $request->nik === null) {
            $msg = $msg . 'NIK Tidak Boleh Kosong <br/> ';
            // array_push($msg, 'NIK Tidak Boleh Kosong');
        }

        if (trim($request->password) === '' || $request->password === null) {
            $msg = $msg . 'Password Tidak Boleh Kosong <br/> ';
            // array_push($msg, 'Password Tidak Boleh Kosong');
        }

        if ($msg === '') {
            $data = User::query()->where('nik', '=', $request->nik);

            if ($data->count() === 0) {
                $msg = $msg . 'NIK Belum Terdaftar <br/> ';
                // array_push($msg, 'NIK Belum Terdaftar');
            }
            if ($data->count() > 0 && Hash::make($request->password) != $data->first()->password) {
                $msg = $msg . 'Password Salah <br/> ';
                // array_push($msg, 'Password Salah');
            }
        }

        return response()->json([
            'isValid' => $msg === '',
            'massage' => $msg,
        ]);
    }
}
