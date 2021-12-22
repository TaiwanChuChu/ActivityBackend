<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ActivityAppliesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->when($this->user_id, function () {
                return (new UserResource(User::find($this->user_id)))->name;
            }),
            'Create' => $this->when($this->CreateID, function () {
                return (new UserResource(User::find($this->CreateID)))->name;
            }),
            'Update' => $this->when($this->CreateID, function () {
                return (new UserResource(User::find($this->CreateID)))->name;
            }),
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'activityBasics' => new ActivityBasicResource($this->whenLoaded('activityBasics')),
            'activityTypes' => (new ActivityTypeCollection($this->whenLoaded('activityTypes'))),
        ];
    }
}

