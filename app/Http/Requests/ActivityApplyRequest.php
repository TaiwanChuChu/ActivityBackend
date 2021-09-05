<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityApplyRequest extends FormRequest
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
            'activity_id' => 'required|integer',
        ];
    }

    public function messages() {
        return [
            'required' => ':attribute欄位為必填欄位!',
            'integer' => ':attribute欄位型別限制為integer!',
        ];
    }

    public function attributes()
    {
        return [
            'activity_id' => '活動ID',
        ];
    }
}
