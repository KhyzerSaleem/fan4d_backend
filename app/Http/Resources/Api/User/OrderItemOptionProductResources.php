<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemOptionProductResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $tax = settings("tax_percent");
        $price_after_tax = $this->price_before_tax + $this->price_before_tax * $tax / 100;
        $total = $price_after_tax - $price_after_tax * $this->discount  / 100;
        return
        [
            'id' => $this->id,
            'image' => $this->main_image,
            'title' => $this->title,
            'description' => $this->description,
            'price_after_tax' => $price_after_tax,
            'discount_percent' => $this->discount,
            'total' => $total,
            'sku' => $this->sku,
            'images' => ServiceImagesResources::collection($this->images),


        ];
    }
}
