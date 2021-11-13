<?php

namespace App\Http\Resources;

use App\Models\ActivityType;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ActivityTypeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function with($request)
    {
        return [
            'meta' => [
                'total' => $request->total,
                'searchCondition' => [],
                'self' => [
                    'headers' => [
                        [
                            'text' => '功能',
                            'value' => 'actions',
                            'sortable' => false,
                        ],
                        [
                            'text' => '活動代碼',
                            'value' => 'type_code',
                        ],
                        [
                            'text' => '活動類別名稱',
                            'value' => 'type_name',
                        ],
                        [
                            'text' => '活動類別使用狀態',
                            'value' => 'state',
                        ],
                    ],
                ],
            ],
        ];
    }
}
