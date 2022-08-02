<?php

namespace App\Http\Middleware;

use App\Models\StoreArea;
use App\Services\CartService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckServiceArea
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
        if(!Session::has('client_area')){
            return redirect()->route('web.dashboard.cart')->with('err', 'Please select delivery area');
        }
        if(Session::has('client_area') && !is_null(auth()->user()->cart_store_id)){
            $storeArea = StoreArea::where(['store_id' => auth()->user()->cart_store_id, 'area_id' => Session::get('client_area')])->first();
           if(!$storeArea){
               return redirect()->route('web.dashboard.cart')->with('err', 'Service provider did not deliver in the selected area.');
           }
        }
        return $next($request);
    }
}
