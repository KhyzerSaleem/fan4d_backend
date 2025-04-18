<?php

namespace App\Http\Resources\Api\User;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class GetPriceDetailsResources extends JsonResource
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
                'subject' => $this->subject,
                'message' => $this->message,
                'reply' => $this->reply,
                'seen_at' => $this->seen_at,
                'created_at' => $this->created_at->translatedformat('d M Y g:i a'),
                'files' =>  $this->files ,

            ];
    }
}
