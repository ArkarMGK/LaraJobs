<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddlware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()) {
            if (url()->current() == route('admin#login')  || Auth::user()->email != 'admin@gmail.com') {
                return back();
            }

            if (Auth::user()->email != 'admin@gmail.com') {
                // abort(404);
                return back();
            }

            return $next($request);
        }

        return $next($request);
    }
}
