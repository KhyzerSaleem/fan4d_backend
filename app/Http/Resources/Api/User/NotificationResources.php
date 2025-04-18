<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResources extends JsonResource
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
            'title' => $this->title,
            'desc' => $this->desc,
            'type' => $this->type,
            'action' => $this->action,
            'target_id' => $this->target_id,
            'target_type' => $this->target_type,
            'created_at'=>$this->created_at

        ];
    }


}
