<?php

namespace App\Http\Resources;

use App\Models\ActivityType;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ActivityTypeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
        return parent::toArray($request);
    }

    public function with($request)
    {
        return [
            'meta' => [
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
