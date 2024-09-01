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

            if (Auth::user()->isAdmin()) {
                return redirect()->route('dashboard')->with('success', 'Sukses login sesi telah dibuat');
            } elseif (Auth::user()->isClient()) {
                return redirect()->route('client-dashboard', ['email' =>  $request->email])->with('success', 'Sukses login sesi telah dibuat');
            } else {
                return redirect()->route('auth.login')->with('error', 'Login Gagal');
            }
        }

        return redirect()->route('auth.login')->with('error', 'Email atau password yang anda masukan salah');
    }

    public function redirectLoginOrRegisterWithGoogle() {

        return Socialite::driver('google')->redirect();
    }


    public function handleLoginOrRegisterWithGoogle() {

        $user = Socialite::driver('google')->user();

        // Validate user and handle accordingly
        $authUser = User::where('google_id', $user->id)->first();

        // Validate user and handle accordingly
        $roleId = Role::where('name', 'Client')->first();

        if ($authUser) {
            Auth::login($authUser);

            return redirect()->route('book-now-landing')->with('success', 'book-now-landing');
        } else {
            $authUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'google_id' => $user->id,
                'role_id' => $roleId->id,
                'avatar' => $user->avatar,
                'password' => bcrypt("LoginWithGoogle@12345"),
                'google_token' => $user->token,
                'google_refresh_token' => $user->refreshToken
            ]);

            Auth::login($authUser);

            return redirect()->route('book-now-landing')->with('success', 'book-now-landing');
        }

        return redirect()->route('home-landing')->with('error', 'home-landing');

    }

    public function logout() {
        if (Auth::check() == true) {
            Session::flush();
            Auth::logout();
            return redirect()->route('auth.login')->with('success', 'Sukses logout sesi telah dihapus');
        } else {

            Session::flush();
            Auth::logout();
            return redirect()->route('auth.login')->with('error', 'Silahkan login terlebih dahulu untuk logout');
        }
    }
}
