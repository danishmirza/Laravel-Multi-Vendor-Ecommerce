<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'visit_time' => $this->visit_time,
            'order_status' => $this->order_status,
            'services_count' => $this->services_count,
            'image' => $this->image,
            'payment_method' => $this->payment_method,
            'subtotal' => $this->subtotal,
            'coupon_discount' => $this->coupon_discount,
            'coupon' => $this->coupon,
            'vat_percentage' => $this->vat_percentage,
            'vat' => $this->vat,
            'service_fees' => $this->service_fees,
            'total' => $this->total,
            'address' => $this->address,
            'store' => $this->store,
            'user' => $this->user,
            'orderDetails' => OrderDetailsResource::collection($this->orderDetails)

        ];
    }
}
