<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function processLogin(Request $req)
    {
        if (Auth::attempt(['email' => $req->email, 'password' => $req->password])) {
            return redirect(route('dashboard'));
        } else {
            return redirect()->back()->with('error', 'Email atau Password Yang Anda Masukan Salah');
        }
    }

    public function logout()
    {
        if (Auth::user()) {
            Auth::logout();
            return redirect()->route('login')->with('success', 'Logout Berhasil, Silahkan Login kembali untuk memakai layanan kami');
        } else {
            return redirect()->back();
        }
    }
}
