<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        if(!$request->user()->isEmailVerified()){
            Session::put('url.intended', URL::full());
            return $request->expectsJson()
                ? abort(403, 'Your email address is not verified.')
                : Redirect::route('web.dashboard.verify-email')->with('err', 'Please verify your email.');
        }
        Session::remove('url.intended');
        return $next($request);
    }
}
