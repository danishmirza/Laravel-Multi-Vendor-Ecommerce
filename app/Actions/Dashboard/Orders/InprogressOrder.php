<?php

namespace App\Actions\Dashboard\Orders;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Service;
use App\Notifications\CartChangedNotification;
use App\Notifications\InprogressOrderNotification;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class InprogressOrder
{
    use AsAction;

    public function handle(Order $order)
    {
        try {
            $order->update(['order_status' => 'in-progress']);
            $order->user->notify(new InprogressOrderNotification($order->id));
            return ['action' => 'status', 'msg' => 'Order status changed to in progress successfully.', 'status' => 'in-progress'];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum', 'verified', 'subscribed'];
    }

    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->isUser()) {
            return Response::deny('You are not allowed to perform this action', 404);
        }
        if( $request->user()->id != $request->order->store_id){
            return Response::deny('You are not allowed to perform this action.', 601);
        }
        if( $request->order->order_status != 'confirmed'){
            return Response::deny('Only confirmed order can be changed to in progress.', 601);
        }
        return Response::allow();
    }

    public function asController(Order $order)
    {

        return $this->handle($order);
    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.dashboard.orders.index', ['order_status' => $paramters['status']]))->with($paramters['action'], $paramters['msg']);
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
        $router->get('dashboard/order/in-progress/{order}', static::class)->name('dashboard.order.in-progress');
    }

}
