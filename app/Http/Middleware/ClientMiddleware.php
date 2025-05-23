<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {

            if (Auth::user()->role->name == "Client" || Auth::user()->role->name == "Admin") {
                return $next($request);
            }

            Session::flush();
            Auth::logout();

            return redirect()->route('book-now-landing')->with('belum-login', 'Anda bukan client');

        } else {

            if (Auth::user()->role->name == "Client" || Auth::user()->role->name == "Admin") {
                return $next($request);
            }

            return redirect()->route('book-now-landing')->with('belum-login', 'Anda bukan client');
        }
    }
}
