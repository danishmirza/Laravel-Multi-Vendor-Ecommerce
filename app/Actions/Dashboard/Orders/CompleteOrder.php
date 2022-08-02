<?php

namespace App\Actions\Dashboard\Orders;

use App\Models\Order;
use App\Models\ServiceReview;
use App\Models\StoreReview;
use App\Notifications\CartChangedNotification;
use App\Notifications\CompletedOrderNotification;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CompleteOrder
{
    use AsAction;

    public function handle(Order $order)
    {
        DB::beginTransaction();
        try {
            $order->update(['order_status' => 'completed']);
            $order->user->notify(new CompletedOrderNotification($order->id));
            StoreReview::create([
                'store_id' => $order->store_id,
                'user_id' => $order->user_id,
                'order_id' => $order->id
            ]);
            $serviceReviews = [];
            if(count($order->orderDetails) > 0){
                foreach ($order->orderDetails as $orderDetail){
                    $serviceReviews[] = [
                        'service_id' => $orderDetail->service_id,
                        'user_id' => $order->user_id,
                        'order_id' => $order->id,
                        'created_at' => Carbon::now()->timestamp,
                        'updated_at' => Carbon::now()->timestamp,
                    ];
                }
                ServiceReview::insert($serviceReviews);
            }
            DB::commit();
            return ['action' => 'status', 'msg' => 'Order completed successfully.', 'status' => 'completed'];
        }catch (\Exception $exception){
            DB::rollBack();
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
        if( $request->order->order_status != 'in-progress'){
            return Response::deny('Only in-progress order can be changed to in completed.', 601);
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
        $router->get('dashboard/order/complete/{order}', static::class)->name('dashboard.order.complete');
    }

}
