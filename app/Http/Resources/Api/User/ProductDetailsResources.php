<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProductDetailsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $is_wishlist = false;
        $need_design_files = false;
        if(\auth()->guard('user')->check()){
            $user = Auth::guard('user')->user();
            if($this->wishlists()->where('user_id',$user->id)->exists()){
                $is_wishlist = true;
            }
        }
        if($this->category->type == 'printing'){
            $need_design_files = true;
        }

        $images_arr = $this->images->pluck('image')->toArray();
        array_unshift($images_arr, $this->image);
        return
            [
                'id' => $this->id,
                'image' => $images_arr,
                'title' => $this->title,
                'description' => $this->description,
                'price_original' => $this->price_original,
                'discount' => $this->discount,
                'price' => $this->price,
                'category' => $this->category->title,
                'custom_quantity_from' => $this->custom_quantity_from,
                'custom_quantity_to' => $this->custom_quantity_to,
                'need_design_files' => $need_design_files,
                'is_wishlist' => $is_wishlist,
                'quantities' => ProductQuantitiesResources::collection($this->quantities),
                'attributes' => ProductAttributesResources::collection($this->attributes_with_options),
            ];
    }
}
