<?php

namespace App\Http\Resources;

use App\Models\SysMenu;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
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
            'p_no' => $this->p_no,
            'p_name' => $this->p_name,
            'mdi-icon' => $this->mdi_icon,
            'status' => $this->status,
            'upper_p_no' => SysMenu::find($this->upper_id)->p_no,
        ];
    }
}
