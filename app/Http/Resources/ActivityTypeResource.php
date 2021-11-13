<?php

namespace App\Http\Resources;

use App\Models\ActivityBasic;
use App\Http\Resources\ActivityBasicResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityTypeResource extends JsonResource
{
    protected $config = [
        'state' => [
            true => '使用中',
            false => '停用中',
        ]
    ];

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
            'type_code' => $this->type_code,
            'type_name' => $this->type_name,
            'state' => $request->hasHeader('X-Methods') ? $this->state : $this->config['state'][$this->state],
            'CreateID' => $this->CreateID,
            'UpdateID' => $this->UpdateID,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'activityBasic' => ActivityBasicResource::collection($this->whenLoaded('activityBasic')),
        ];
    }
}
