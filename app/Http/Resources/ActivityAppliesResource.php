<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityAppliesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'activity_id' => $this->activity_id,
            'CreateID' => $this->when($this->CreateID, function() {
                return (new UserResource(User::find($this->CreateID)))->name;
            }),
            'user_id' => $this->when($this->user_id, function() {
                return (new UserResource(User::find($this->user_id)))->name;
            }),
            'activityBasics' => $this->whenLoaded('activityBasics'),
        ];
    }
}
