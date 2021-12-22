<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityBasicResource extends JsonResource
{

    protected $config = [
        'apply_state' => [
            true => '開放報名中',
            false => '尚未開放報名',
        ]
    ];

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
            'activity_type_id' => $this->activity_type_id,
            'theme' => $this->theme,
            'description' => $this->description,
            'place' => $this->place,
            'apply_limit' => $this->apply_limit,
            'apply_sdate' => Carbon::parse($this->apply_sdate)->toDateTimeString(),
            'apply_edate' => Carbon::parse($this->apply_edate)->toDateTimeString(),
            'apply_state' => $this->apply_state,
            'apply_state_text' => $this->config['apply_state'][$this->apply_state],
            'sdate' => Carbon::parse($this->sdate)->toDateTimeString(),
            'edate' => Carbon::parse($this->edate)->toDateTimeString(),
            'activityType' => $this->whenLoaded('activityType'),
        ];
    }

    // public function with($request) {
        // return [
        //     'headers' => 'fuck',
        // ];
    // }
}
