<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Month extends JsonResource
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
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'user_id'=>$this->user_id,
            'updated_at'=>$this->updated_at->diffForHumans(),
        ];
        // return parent::toArray($request);
    }
}
