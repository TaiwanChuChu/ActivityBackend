<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ActivityAppliesCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function with($request) {
        return [
            'meta' => [
                'total' => 0,
                'searchCondition' => [],
                'self' => [
                    'headers' => [
                        'activity_id' => '活動ID',
                        'CreateID' => '建立者ID',
                        'UpdateID' => '異動者ID',
                        'created_at' => '建立時間',
                        'updated_at' => '異動時間',
                    ], 
                ]
            ],
        ];
    }
}
