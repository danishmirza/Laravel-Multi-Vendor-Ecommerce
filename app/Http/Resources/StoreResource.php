<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'store_name' => $this->store_name,
            'image' => $this->image,
            'slug' => $this->slug,
            'address' =>  $this->address,
            'latitude' => (double)$this->latitude,
            'longitude' => (double)$this->longitude,
            'average_rating' => $this->average_rating,
            'city' => CityResource::make($this->city),
            'email' => $this->email,
            'phone' => $this->phone,
            'detail' => $this->detail,
            'store_review_id' => (auth()->check()) ? ($this->storeReview) ? $this->storeReview->id : 0 : 0
        ];
    }
}
