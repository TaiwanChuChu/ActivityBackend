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
                'total' => $request->total,
                'searchCondition' => [
                    'activityType' => $request->activityTypeOption,
                ],
                'self' => [
                    'headers' => [
                        [
                            'text' => '功能',
                            'value' => 'id',
                            'sortable' => false,
                            // align: 'start',
                            // filterable: false,
                            // sortable: true,
//                            'width' => '16%',
                        ],
                        [
                            'text' => '活動類別',
                            'value' => 'activityTypes.type_name',
                        ],
                        [
                            'text' => '活動主題',
                            'value' => 'activityBasics.theme',
                        ],
                        [
                            'text' => '活動地點',
                            'value' => 'activityBasics.place',

                        ],
                        [
                            'text' => '活動時間起',
                            'value' => 'activityBasics.sdate',

                        ],
                        [
                            'text' => '活動時間訖',
                            'value' => 'activityBasics.edate',

                        ],
                        [
                            'text' => '參加人',
                            'value' => 'user',
                        ],
                        [
                            'text' => '填表人',
                            'value' => 'Create',
                        ],
                        [
                            'text' => '報名時間',
                            'value' => 'created_at',
                        ],
                    ],
                ]
            ],
        ];
    }
}
