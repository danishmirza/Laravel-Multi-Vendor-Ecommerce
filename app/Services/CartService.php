<?php


namespace App\Services;


use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\StoreArea;

class CartService
{
    public function userCart($userId){
        return Cart::where(['user_id' => $userId])
            ->whereHas('service')
            ->whereHas('store')
            ->with(['service' => function($query){
                $query->select('id', 'title', 'average_rating', 'image',  'has_offer',
                    'price','discount_percentage')
                    ->selectRaw('(price - (price * discount_percentage / 100)) AS actual_price');
            }, 'store:id,store_name'])
            ->get();
    }

    public function getAddressAndServiceFees($addressId, $selectedArea = null){
        try {
            $serviceFees = 0;
            $query = Address::where('id', $addressId);
            if($selectedArea){
                $query->where('area_id', $selectedArea);
            }
            $defaultAddress = $query->with(['city:id,title', 'area:id,title'])->first();
            if($defaultAddress && $defaultAddress->area){
                $storeArea = StoreArea::where(['store_id' => auth()->user()->cart_store_id, 'area_id' => $defaultAddress->area->id])->first();
                if($storeArea){
                    $serviceFees = $storeArea->price;
                }
            }
            return ['address' => $defaultAddress, 'serviceFees' => $serviceFees];
        }catch (\Exception $exception){
            return ['address' => null, 'serviceFees' => 0];
        }
    }

    public function userCoupon($userId){
        return Coupon::find($userId);
    }
}
