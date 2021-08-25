<?php

namespace App\Http\Resources;

use App\Models\ActivityBasic;
use App\Http\Resources\ActivityBasicResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityTypeResource extends JsonResource
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
            'id' => $this->id,
            'type_code' => $this->type_code,
            'type_name' => $this->type_name,
            'state' => $this->state,
            'CreateID' => $this->CreateID,
            'UpdateID' => $this->UpdateID,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'activityBasic' => ActivityBasicResource::collection($this->whenLoaded('activityBasic')),
        ];
    }

     public function with($request)
    {
        return [
            'meta' => [
                'key' => 'value',
                'headers' => [
                    'id' => 'key',
                    'type_code' => '活動代碼',
                    'type_name' => '活動名稱',
                    'state' => '活動類別使用狀態',
                    'CreateID' => '建立者',
                    'UpdateID' => '異動者',
                    'created_at' => '建立時間',
                    'updated_at' => '異動時間',
                ],
            ],
        ];
    }
}
