<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class EnsureSubscriptionIsPurchased
{
    public function handle(Request $request, Closure $next)
    {
        if($request->user()->isUser()){
            return $next($request);
        }

        if($request->user()->isNotSubscribed()){
            Session::put('url.intended', URL::full());
            return $request->expectsJson()
                ? abort(403, 'Please subscribe to a package.')
                : Redirect::route('web.dashboard.subscription')->with('err', 'Please subscribe to a package.');
        }
        if($request->user()->isSubscriptionExpired()){
            Session::put('url.intended', URL::full());
            return $request->expectsJson()
                ? abort(403, 'Your subscription has expired.')
                : Redirect::route('web.dashboard.subscription')->with('err', 'Your subscription has expired.');
        }
        Session::remove('url.intended');
        return $next($request);
    }
}
