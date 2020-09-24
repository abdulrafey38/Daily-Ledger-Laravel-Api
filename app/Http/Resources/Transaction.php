<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Transaction extends JsonResource
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
            'supplier_id'=>$this->supplier->id,
            'product_id'=>$this->product_id,
            'date'=>$this->date,
            'updated_at'=>$this->updated_at->diffForHumans(),
            'quantity'=>$this->quantity,
            'price'=>$this->price,
            'supplier'=>$this->supplier->name,
            'product'=>$this->product->name,
            'month_id'=>$this->month_id,
            'month'=>$this->month->name,
         


        ];
        // return parent::toArray($request);
    }
}
