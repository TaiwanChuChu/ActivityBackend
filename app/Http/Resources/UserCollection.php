<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
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
                'headers' => [
                    'id' => 'key',
                    'u_no' => '帳號',
                    'name' => '姓名',
                    'email' => 'Email',
                ],
            ],
        ];
    }
}
