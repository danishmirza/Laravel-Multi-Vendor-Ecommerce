<?php


namespace App\Actions\Dashboard\Cart;


use App\Models\Cart;
use App\Models\City;
use App\Models\Service;
use App\Models\StoreArea;
use App\Notifications\CartChangedNotification;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Session;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class AddItemToCart
{
    use AsAction;

    public function handle($serviceId, $storeId, $areaId)
    {
        try {
            StoreArea::where(['store_id' => $storeId, 'area_id' => $areaId])->firstOrFail(['*'], 'This service provider does not serve in this area.');
            $cartItem = Cart::create([
                'user_id' => auth()->id(),
                'store_id' => $storeId,
                'service_id' => $serviceId
            ]);
            auth()->user()->update(['cart_store_id' => $cartItem->store_id]);
            auth()->user()->notify(new CartChangedNotification());
            return ['action' => 'status', 'msg' => 'Service added to cart successfully.', 'areaId' => $areaId];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum', 'verified'];
    }

    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->isStore()) {
            return Response::deny('You are not allowed to perform this action', 404);
        }
        if(!is_null($request->user()->cartStoreId()) && $request->user()->cartStoreId() != $request->service->store_id){
            return Response::deny('Ony one provider services are allowed in the cart at a time.', 601);
        }
        if(!isset($request->area) || is_null($request->area)){
            return Response::deny('Please select service area.', 601);
        }
        return Response::allow();
    }


    public function asController(Service $service, City $area)
    {
        return $this->handle($service->id, $service->store_id, $area->id);
    }

    public function htmlResponse($paramters)
    {
        if(!Session::has('client_area')){
            Session::put('client_area', $paramters['areaId']);
        }
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.dashboard.cart'))->with($paramters['action'], $paramters['msg']);
    }

    public function jsonResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return responseBuilder()->error($paramters['msg']);
        }
        return responseBuilder()->success($paramters['msg']);
    }

    public static function routes(Router $router)
    {
        $router->get('dashboard/cart/add-to-cart/{service}/{area?}', static::class)->name('dashboard.cart.add-to-cart');
    }

}
