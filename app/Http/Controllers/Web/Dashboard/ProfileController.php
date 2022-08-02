<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\StoreArea;
use App\Services\CartService;
use App\Services\CityAreaService;
use App\Services\PackageService;
use App\Services\StoreAreaService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use PHPUnit\Exception;

class ProfileController extends Controller{

    public function profile(){
        return view('web.dashboard.profile.profile');
    }

    public function editProfileUser(){
        return view('web.dashboard.profile.edit-profile-user');
    }

    public function editProfileStore(CityAreaService $cityAreaService){
        return view('web.dashboard.profile.edit-profile-store', ['cities' => $cityAreaService->getAllCitiesWithAreas()]);
    }

    public function changePassword(){
        return view('web.dashboard.profile.change-password');
    }

    public function subscription(PackageService $packageService){
        return view('web.dashboard.profile.subscription', ['packages' => $packageService->getSubscriptionPackages()]);
    }

    public function verifyEmail(){
        return view('web.dashboard.profile.verify-email');
    }

    public function notifications(){
        return view('web.dashboard.notifications.index');
    }

    public function addresses(CityAreaService $cityAreaService){
        return view('web.dashboard.addresses.index', ['cities' => $cityAreaService->getAllCitiesWithAreas()]);
    }

    public function cart(CartService $cartService, StoreAreaService $storeAreaService){
        $cartItems = $cartService->userCart(auth()->id());
        $isServiceAreaCorrect = false;
        $storeAreas = [];
        if (count($cartItems) <= 0){
            $isServiceAreaCorrect = true;
        }
        if(Session::has('client_area') && count($cartItems) > 0){
//            dd(['store_id' => auth()->user()->cart_store_id, 'area_id' => Session::has('client_area')]);
            $storeArea = StoreArea::where(['store_id' => auth()->user()->cart_store_id, 'area_id' => Session::get('client_area')])->first();
            if($storeArea){
               $isServiceAreaCorrect = true;
            }
        }
        if(!$isServiceAreaCorrect){
            $storeAreas = $storeAreaService->storeAreas(auth()->user()->cart_store_id, false);
        }
        return view('web.dashboard.cart.index', ['cartItems' => $cartItems, 'isServiceAreaCorrect' => $isServiceAreaCorrect, 'storeAreas' => $storeAreas]);
    }

    public function checkout(CartService $cartService, CityAreaService $cityAreaService){
        try {
            $dateTime = Carbon::createFromFormat('d-m-Y H:i', request('cart_date').' '.request('cart_time'));
            if($dateTime->startOfDay()->diffInDays(Carbon::now()->startOfDay(), false) >= 0){
                return redirect()->back()->withInput()->with('err', 'Visit date and time must be greater then today');
            }
            $cartItems = $cartService->userCart(auth()->id());
            if(count($cartItems) <= 0){
                return redirect()->back()->withInput()->with('err', 'Your cart is empty.');
            }
            $addressId = request('address_id', auth()->user()->default_address_id);
            $defaultAddress = null; $serviceFees = 0;
            if(!is_null($addressId)){
                $addressAndServiceFees = $cartService->getAddressAndServiceFees($addressId);
                $defaultAddress = $addressAndServiceFees['address'];
                $serviceFees = $addressAndServiceFees['serviceFees'];
            }
            $appliedCoupon = $cartService->userCoupon(auth()->user()->applied_coupon_id);
//            dd($appliedCoupon);
            return view('web.dashboard.checkout.index', [
                'dateTime' => $dateTime,
                'cartItems' => $cartItems,
                'cities' => $cityAreaService->getAllCitiesWithAreas(),
                'defaultAddress' => $defaultAddress,
                'appliedCoupon' => $appliedCoupon,
                'serviceFees' => $serviceFees,
                'vat' => 5,
                'paymentMethod' => request('payment_method', 'cash')
            ]);
        }catch (\Exception $exception){
            return redirect()->back()->withInput()->with('err', 'Date is not correct');
        }

    }


}
