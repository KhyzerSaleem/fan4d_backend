<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResources extends JsonResource
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
            'order_number' => $this->order_number,
            'sub_total' => $this->sub_total,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'shipping_cost' => $this->shipping_cost,
            'total' => $this->total,
            'status' => $this->status,
            'status_text' => trans('lang.order_'.$this->status),
            'payment_method' => $this->payment_method,
            'payment_method_text' => trans('lang.'.$this->payment_method),
            'items' => OrderItemsResources::collection($this->items),
            'address' => new OrderAddressesResources($this->address),
        ];
    }
}
