<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    protected array $guards;

    public function handle($request, Closure $next, ...$guards)
    {
        $this->guards = $guards;
        $this->authenticate($request, $guards);
        return $next($request);
    }

    protected function redirectTo($request)
    {
        if (in_array('admin',$this->guards)){
            return route('admin.auth.login.form');
        }else{
            if (Auth::user()) {
                return route('web.dashboard.profile');
            }else{
                return route('web.auth.login');
            }
        }
    }
}
