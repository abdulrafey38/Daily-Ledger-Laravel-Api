<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Supplier extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'phone_number'=>$this->phone_number,
            'user_id'=>$this->user_id,
            'updated_at'=>$this->updated_at->diffForHumans(),
            
        ];
        // return parent::toArray($request);
    }
}
