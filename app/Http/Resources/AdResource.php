<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
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
            'title' => $this->title,
            'sub_title' =>  $this->sub_title,
            'content' =>  $this->content,
            'image' =>  $this->image,
            'ad_status' =>  $this->ad_status,
            'store' =>  $this->store,
        ];
    }
}
