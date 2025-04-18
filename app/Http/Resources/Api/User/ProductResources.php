<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProductResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = Auth::guard('user')->user();
        return
            [
                'id' => $this->id,
                'image' => $this->image,
                'title' => $this->title,
                'price' => $this->price,
                'description' => $this->description,
//                'is_favorite' => $user ? $user->favourites()->where('product_id', $this->id)->exists() : false,
            ];
    }
}
