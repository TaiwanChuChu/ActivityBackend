<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type_code' => 'required|max:10',
            'type_name' => 'required|max:50',
            'state' => 'required|boolean',
        ];
    }

    public function messages() {
        return [
            'required' => ':attribute欄位為必填欄位!',
            'max' => ':attribute欄位長度限制為 :max字!',
            'boolean' => ':attribute欄位型別限制為boolean!',
        ];
    }

    public function attributes()
    {
        return [
            'type_code' => '活動類別代碼',
            'type_name' => '活動類別名稱',
            'state' => '活動類別使用狀態',
        ];
    }
}
