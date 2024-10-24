<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            session()->flash('belum-login', 'You need to be logged in to access this page.');
            return route('book-now-landing');
        } else {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }
}
