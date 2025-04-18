<?php

namespace App\Http\Resources\Api\User;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
        [
            'id' => $this->id,
            'image' => $this->image,
            'title' => $this->title,
            'published_at' => Carbon::parse($this->published_at)->translatedFormat('M d'),
            'description' => $this->description,
        ];
    }
}
