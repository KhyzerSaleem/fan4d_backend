<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderUserCarResources extends JsonResource
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
            'brand' => $this->brand->title,
            'modell' => $this->modell->title,
            'production_year' => $this->productionYear->year,
            'car_color' => $this->carColor->title,
        ];
    }


}
