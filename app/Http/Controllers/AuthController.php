<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index() {
        return view('pages.auth.login.index');
    }

    public function login(LoginRequest $request) {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard')->with('success', 'Sukses login sesi telah dibuat');
        }

        return redirect()->route('auth.login')->with('error', 'Email atau password yang anda masukan salah');
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return redirect()->route('auth.login')->with('success', 'Sukses logout sesi telah dihapus');
    }
}
