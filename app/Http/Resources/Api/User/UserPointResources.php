<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPointResources extends JsonResource
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
            'order_number' => $this->order?->order_number,
            'points' => $this->points,
            'type' => $this->type,
            'money' => $this->money,
            'created_at' => $this->created_at->translatedformat('M d,Y g:i a'),
        ];
    }


}
