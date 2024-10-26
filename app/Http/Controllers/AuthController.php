<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    public function index() {
        return view('pages.auth.login.index');
    }

    public function login(LoginRequest $request) {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            if ($user->isAdmin()) {
                return redirect()->route('dashboard')->with('success', 'Sukses login sesi telah dibuat');
            } elseif ($user->isClient()) {
                return redirect()->route('client-dashboard', ['email' =>  $request->email])->with('success', 'Sukses login sesi telah dibuat');
            }

            return redirect()->route('auth.login')->with('error', 'Login Gagal');
        }

        return redirect()->route('auth.login')->with('error', 'Email atau password yang anda masukan salah');
    }

    public function redirectLoginOrRegisterWithGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function handleLoginOrRegisterWithGoogle() {
        $googleUser = Socialite::driver('google')->user();
        $authUser = User::where('google_id', $googleUser->id)->first();
        $roleId = Role::where('name', 'Client')->first();

        if (!$roleId) {
            return redirect()->route('auth.login')->with('error', 'Role Client tidak ditemukan');
        }

        if ($authUser) {
            Auth::login($authUser);
            return redirect()->route('book-now-landing')->with('success', 'Sukses login dengan Google');
        }

        $authUser = User::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'google_id' => $googleUser->id,
            'role_id' => $roleId->id,
            'avatar' => $googleUser->avatar,
            'password' => bcrypt("LoginWithGoogle@12345"),
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken
        ]);

        Auth::login($authUser);

        return redirect()->route('book-now-landing')->with('success', 'Akun baru berhasil dibuat dan login dengan Google');
    }

    public function logout() {

        if (Auth::check()) {
            $user = Auth::user();
            $redirectRoute = $user->role->name === "Client" ? 'book-now-landing' : 'auth.login';

            Session::flush();
            Auth::logout();

            return redirect()->route($redirectRoute)->with('success', 'Sukses logout sesi telah dihapus');
        }

        return redirect()->route('auth.login')->with('error', 'Silahkan login terlebih dahulu untuk logout');
    }
}
