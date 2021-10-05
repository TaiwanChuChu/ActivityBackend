<?php

namespace App\Http\Resources;

use App\Models\SysMenu;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
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
            'p_no' => $this->p_no,
            'p_name' => $this->p_name,
            'mdi_icon' => $this->mdi_icon,
            'children' => $this->whenLoaded('children'),
        ];
    }
}
