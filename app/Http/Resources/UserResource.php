<?php

namespace App\Http\Resources;

use App\Http\Resources\FileStorageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'u_no' => $this->u_no,
            'name' => $this->name,
            'email' => $this->email,
            'headshot' => $this->when($this->whenLoaded('file_storages') instanceof \Illuminate\Http\Resources\MissingValue === false, function() {
                return FileStorageResource::collection($this->whenLoaded('file_storages'))->where('token', '=', 'headshot');
            }),
        ];
    }
}
