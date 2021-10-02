<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        switch($request->method) {
            case 'PUT':
                return $this->user()->can('update', $this->user);
        }
        return true;
    }

    protected $rules = [
        'POST' => [
            'u_no' => 'required|unique:App\Models\User|string|max:255',
        ],
        'PUT' => [
            'password' => 'required|string|max:255|sometimes',
            'headshot' => 'required|image|max:6144|sometimes',
        ],
        'DEFAULT' => [
            'password' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'headshot' => 'required|image|sometimes',
        ]
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return $this->getRuleByMethod($request->method);
    }

    public function getRuleByMethod($method) {
        if(array_key_exists($method, $this->rules) === false) {
            throw new \Exception('Error!');
        }
        return array_merge($this->rules['DEFAULT'], $this->rules[$method]);
    }

    public function messages() {
        return [
            'required' => ':attribute欄位為必填欄位!',
            'unique' => ':attribute已被使用!',
            'max' => ':attribute欄位長度限制為 :max字!',
            'string' => ':attribute欄位型別限制為字串!',
            'email' => ':attribute欄位型別限制為email!',
            'image' => ':attribute格式不符!',
        ];
    }

    public function attributes() {
        return [
            'u_no' => '帳號',
            'password' => '密碼',
            'name' => '姓名',
            'email' => 'Email',
            'headshot' => '個人照片',
        ];
    }
}
