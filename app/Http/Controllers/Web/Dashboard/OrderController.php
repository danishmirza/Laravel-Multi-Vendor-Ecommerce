<?php


namespace App\Http\Controllers\Web\Dashboard;


use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function orders(OrderService $orderService){
        try {
            return view('web.dashboard.orders.index', ['orders' => $orderService->userOrders(auth()->id(), auth()->user()->user_type, request('order_status', 'all'))]);
        } catch (\Exception $e) {
            return redirect()->route('web.dashboard.profile')->with('err', $e->getMessage());
        }
    }

    public function detail(Order $order, OrderService $orderService){
        try {
            return view('web.dashboard.orders.detail', ['order' => $orderService->orderDetail($order)]);
        } catch (\Exception $e) {
            return redirect()->route('web.dashboard.profile')->with('err', $e->getMessage());
        }
    }
}