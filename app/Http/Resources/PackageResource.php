<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $keys =  [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'duration_type' =>  $this->duration_type,
            'duration' => $this->duration,
            'is_free' => $this->is_free,
        ];
        if(isset($this->purchased_packages_count)){
            $keys['purchased_packages_count'] = $this->purchased_packages_count;
        }
        return $keys;
    }
}
