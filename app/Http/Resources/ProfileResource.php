<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->isUser()){
            return $this->userResource($request);
        }else{
            return $this->storeResource($request);
        }
    }

    private function userResource($request){
        return [
          'id' => $this->id,
          'user_type' => $this->user_type,
          'name' => $this->name,
          'email' => $this->email,
          'phone' => $this->phone,
          'address' =>$this->address,
          'longitude' =>(float)$this->longitude,
          'latitude' =>(float)$this->latitude,
          'image' =>$this->image,
          'email_verified' =>$this->email_verified,
          'is_notification_enabled' =>$this->is_notification_enabled,
            'email_verification_code' => $this->email_verification_code,
            'token' => $request->bearerToken()
        ];
    }

    private function storeResource($request){
        return [
            'id' => $this->id,
            'user_type' => $this->user_type,
            'store_name' => $this->store_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' =>$this->address,
            'longitude' =>(float)$this->longitude,
            'latitude' =>(float)$this->latitude,
            'image' =>$this->image,
            'trade_license' =>$this->trade_license,
            'email_verified' =>$this->email_verified,
            'is_notification_enabled' =>$this->is_notification_enabled,
            'trade_license_verified' =>$this->trade_license_verified,
            'subscription_ends_date' =>$this->subscription_ends_date,
            'city' => new CityResource($this->city),
            'detail' => $this->detail,
            'email_verification_code' => $this->email_verification_code,
            'total_earnings' => $this->total_earnings,
            'amount_remaining' => $this->amount_remaining,
            'amount_on_hold' => $this->amount_on_hold,
            'amount_withdrawn' => $this->amount_withdrawn,
            'token' => $request->bearerToken()
        ];
    }
}
