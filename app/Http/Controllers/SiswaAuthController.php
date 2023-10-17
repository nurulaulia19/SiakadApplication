<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\SessionGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class SiswaAuthController extends Controller
{
    public function showLoginForm()
{
    return view('auth.loginSiswa');
}

public function login(Request $request)
{
    $credentials = $request->only('nis_siswa', 'password');
    
    if (Auth::guard('siswa')->attempt($credentials)) {
        return redirect()->intended('siswa/home');
    }

    return redirect()->back()->withErrors(['loginError' => 'NIS Siswa atau password salah.']);
}

// public function login(Request $request)
// {
//     $credentials = $request->only('nis_siswa', 'password');

//     if (Auth::guard('siswa')->attempt($credentials)) {
//         // Autentikasi berhasil
//         $user = auth()->guard('siswa')->user();
//         $nis_siswa = $user->nis_siswa;
//         // Lanjutkan dengan mengakses data siswa sesuai kebutuhan
//         return redirect()->intended('siswa/home'); // Ganti 'home' dengan rute yang sesuai
//     }

//     // Autentikasi gagal
//     return redirect()->back()->withErrors(['loginError' => 'NIS Siswa atau password salah.']);
// }


}
