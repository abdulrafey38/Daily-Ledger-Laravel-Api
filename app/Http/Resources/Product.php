<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'price'=>$this->price,
            'updated_at'=>$this->updated_at,
            'supplier_id'=>$this->supplier_id,
            'supplier'=>$this->supplier->name

        ];
        // return parent::toArray($request);
    }
}