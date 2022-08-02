<?php


namespace App\Http\Controllers\API\Dashboard;


use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Http\Resources\CartItemsListResource;
use App\Services\CartService;

class CartController extends Controller
{
    public function cart(CartService $cartService)
    {
        $cartItems = CartItemsListResource::collection($cartService->userCart(auth()->id()));
        return responseBuilder()->success('Cart', $cartItems);
    }

    public function supportingData(CartService $cartService){
        try {
            $addressId = request('address_id', auth()->user()->default_address_id);
            $addressAndServiceFees = ['address' => null, 'serviceFees' => 0];
            if(!is_null($addressId)){
                $addressAndServiceFees = $cartService->getAddressAndServiceFees($addressId);
                if(!is_null($addressAndServiceFees['address'])){
                    $addressAndServiceFees['address'] = AddressResource::make($addressAndServiceFees['address']);
                }
            }
            $addressAndServiceFees['applied_coupon'] = $cartService->userCoupon(auth()->user()->applied_coupon_id);
            return responseBuilder()->success('Cart Supporting Data', $addressAndServiceFees);
        }catch (\Exception $exception){
            return responseBuilder()->error($exception->getMessage());
        }

    }

}
