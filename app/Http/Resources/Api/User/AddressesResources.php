<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressesResources extends JsonResource
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
            'id' => (int)$this->id,
            'title' => (string)$this->title,
            'address' => (string)$this->address,
            'street' => (string)$this->street,
            'house_number' => (string)$this->house_number,
            'lat' => (string)$this->lat,
            'lng' => (string)$this->lng,
            'city' => (string)$this->city->title,
            'city_id' => $this->city_id,
            'area' => (string)$this->area->title,
            'area_id' => $this->area_id,
            'shipping_cost' => $this->area->cost,
            'is_default' => (int)$this->is_default,
        ];
    }


}
