<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ActivityBasicCollection extends ResourceCollection
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

    public function with($request)
    {
        return [
            'meta' => [
                'total' => $request->total,
                'searchCondition' => [
                    'activityType' => $request->activityTypeOption,
                ],
                'self' => [
                    'headers' => [
//                        [
//                            'text' => 'openDetail',
//                            'value' => 'data-table-expand',
//                            'sortable' => false,
//                        ],
                        [
                            'text' => '功能',
                            'value' => 'actions',
                            'sortable' => false,
                        ],
                        [
                            'text' => '活動類別',
                            'value' => 'activityType.type_name',
                            'sortable' => false,
                        ],
                        [
                            'text' => '活動主題',
                            'value' => 'theme',
                        ],
                        [
                            'text' => '活動內容',
                            'value' => 'description',
                        ],
                        [
                            'text' => '活動地點',
                            'value' => 'place',
                        ],
                        [
                            'text' => '報名人數上限',
                            'value' => 'apply_limit',
                        ],
                        [
                            'text' => '報名時間起',
                            'value' => 'apply_sdate',
                        ],
                        [
                            'text' => '報名時間訖',
                            'value' => 'apply_edate',
                        ],
                        [
                            'text' => '報名狀態',
                            'value' => 'apply_state_text',
//                            'value' => 'apply_state',
                        ],
                        [
                            'text' => '活動時間起',
                            'value' => 'sdate',
                        ],
                        [
                            'text' => '活動時間訖',
                            'value' => 'edate',
                        ],
                    ],
                ],
                'activityType' => [
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
                ]
            ],
        ];
    }
}
