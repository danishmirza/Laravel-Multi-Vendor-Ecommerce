<?php


namespace App\Services;


use App\Models\Order;
use App\Models\User;

class OrderService
{
    public function userOrders($userId, $userType, $status="all"){
        try {
            $query = Order::query();
            if($userType==User::$USER){
                $query->where('user_id', $userId);
            }
            if($userType==User::$STORE){
                $query->where('store_id', $userId);
            }
            if($status != 'all'){
                $query->where('order_status', $status);
            }
            return $query->select('id', 'order_number', 'visit_time', 'order_status', 'services_count', 'image', 'total')
                ->orderByDesc('created_at')->paginate(10);
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }

    public function orderDetail(Order $order){
        try {
            $orderDetailCallback = function ($query){
                $query->with('service:id,title,average_rating');
            };
            $order->load(['store:id,store_name,email,phone,image', 'user:id,name,email,phone,image', 'orderDetails' => $orderDetailCallback]);
            return $order;
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }
}
