<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // Skip redirection for POST /register route
        if ($request->is('register') && $request->method() === 'POST') {
            return $next($request);
        }

        if (Auth::guard($guard)->check() && (Auth::user()->role_id == 1 || Auth::user()->role_id == 3)) {
            return redirect(route('faculty'));
        } elseif (Auth::guard($guard)->check() && Auth::user()->role_id == 2) {
            return redirect(route('exam'));
        } else {
            return $next($request);
        }
    }
}
