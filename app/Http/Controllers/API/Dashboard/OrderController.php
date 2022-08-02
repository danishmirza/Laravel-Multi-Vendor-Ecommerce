<?php


namespace App\Http\Controllers\API\Dashboard;


use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrdersCollection;
use App\Models\Order;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function orders(OrderService $orderService)
    {
        try {
            $orders = new OrdersCollection($orderService->userOrders(auth()->id(), auth()->user()->user_type, request('order_status', 'all')));
            return responseBuilder()->success('Orders', $orders);
        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }

    public function detail(Order $order, OrderService $orderService){
        try {
            $order = OrderResource::make($orderService->orderDetail($order));
            return responseBuilder()->success('Orders', $order);
        }catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
}
