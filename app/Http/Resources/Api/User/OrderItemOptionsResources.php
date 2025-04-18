<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemOptionsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product' => new OrderItemOptionProductResources($this->product),
            'attribute_title' => $this->attribute_title ,
            'option_title' => $this->option_title ,
            'additional_price' => $this->additional_price ,


        ];
    }
}
