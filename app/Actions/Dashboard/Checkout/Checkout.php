<?php


namespace App\Actions\Dashboard\Checkout;


use App\Actions\Dashboard\Cart\ClearCart;
use App\Models\Address;
use App\Models\Cart;
use App\Models\City;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\StoreArea;
use App\Notifications\OrderCreatedNotification;
use App\Services\CartService;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use function PHPUnit\Framework\throwException;

class Checkout
{
    use AsAction;

    public function handle($data, $areaId)
    {
//        dd($data);
        DB::beginTransaction();
        try {
            StoreArea::where(['store_id' => auth()->user()->cart_store_id, 'area_id' => $areaId])->firstOrFail(['*'], 'This service provider does not serve in this area.');
            $cartService = new CartService();
            $cartItems = $cartService->userCart(auth()->id());
            if (count($cartItems) <= 0){
                throw new \Exception('Your cart is empty');
            }
            $addressAndFees = $cartService->getAddressAndServiceFees($data['address_id']);
            if(is_null($addressAndFees['address'])){
                throw new \Exception('Could not find the address');
            }
//            dd($cartItems);
            $subtotal = $cartItems->sum('service.actual_price'); $discount = 0; $serviceFees = $addressAndFees['serviceFees']; $vatPercentage =5; $vat = 0 ; $total = 0;
            $total =  $subtotal;
            $coupon = null;
            if(auth()->user()->isCouponApplied()){
                $coupon = Coupon::findOrFail(auth()->user()->applied_coupon_id, ['*'], 'Could not find the applied coupon');
                $discount = ($coupon->discount/100) * $subtotal;
                $total = $subtotal-$discount;
            }
            $vat = ($vatPercentage/100) * $total;
            $total = $total + $vat;
            $total = $total + $serviceFees;
            $order = Order::create([
                'user_id' => auth()->id(),
                'store_id' => auth()->user()->cart_store_id,
                'order_number' => Order::generateRandomString(5),
                'address' => json_encode($addressAndFees['address']),
                'visit_time' => $data['visit_time'],
                'payment_method' => $data['payment_method'],
                'subtotal' => (float)$subtotal,
                'coupon_discount' => (float)$discount,
                'coupon' => json_encode($coupon),
                'vat_percentage' => (float)$vatPercentage,
                'vat' => (float)$vat,
                'service_fees' => (float)$serviceFees,
                'total' => (float)$total,
                'services_count' => count($cartItems),
                'image' => $cartItems[0]->service->image

            ]);
            $orderItems = [];
            foreach ($cartItems as $cartItem){
                $orderItems[] = [
                    'user_id' => auth()->id(),
                    'store_id' => auth()->user()->cart_store_id,
                    'order_id' => $order->id,
                    'service_id' => $cartItem->service->id,
                    'price' => $cartItem->service->actual_price,
                    'image' => $cartItem->service->image,
                    'created_at' => Carbon::now()->timestamp,
                    'updated_at' => Carbon::now()->timestamp,
                ];
            }
            OrderDetail::insert($orderItems);
            ClearCart::run();
            auth()->user()->update(['applied_coupon_id' => null]);
            $order->store->notify(new OrderCreatedNotification($order->id, 'store'));
            auth()->user()->notify(new OrderCreatedNotification($order->id, 'user'));
            DB::commit();
            return ['action' => 'status', 'msg' => 'Order created successfully.', 'status' => 'pending'];
        }catch (\Exception $exception){
            DB::rollBack();
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
        return Response::allow();
    }

    public function rules(ActionRequest $request)
    {
        return [
            'payment_method' => 'required|in:cash',
            'visit_time' => 'required',
            'address_id' => 'required|exists:addresses,id'
        ];
    }

    public function asController(City $area, ActionRequest $request)
    {
        return $this->handle($request->validated(), $area->id);
    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.dashboard.orders.index'))->with($paramters['action'], $paramters['msg']);
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
        $router->post('dashboard/checkout/submit/{area}', static::class)->name('dashboard.checkout.submit');
    }

}
