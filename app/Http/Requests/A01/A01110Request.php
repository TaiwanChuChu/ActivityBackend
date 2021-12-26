<?php

namespace App\Http\Requests\A01;

use App\Contracts\IFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class A01110Request extends FormRequest implements IFormRequest
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

    protected function defaultRule(): array
    {
        return [
            'type_code' => [
                'required',
                'max:10',
                'string',
                Rule::unique('activity_types'),
            ],
            'type_name' => 'required|string|max:50',
            'state' => 'boolean',
        ];
    }

    protected function ruleByPost(): array
    {
        return [];
    }

    protected function ruleByPut(): array
    {
        return [
            'type_code' => false,
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];
        switch (request()->method) {
            case 'POST':
                $rules = $this->ruleByPost();
                break;
            case 'PUT':
                $rules = $this->ruleByPut();
                break;
        }
        return array_filter(array_merge($this->defaultRule(), $rules));
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute欄位為必填欄位!',
            'max' => ':attribute欄位長度限制為 :max字!',
            'boolean' => ':attribute欄位型別限制為boolean!',
            'string' => ':attribute欄位型別限制為字串!',
            'unique' => ':attribute欄位不可重複!',
        ];
    }

    public function attributes(): array
    {
        return [
            'type_code' => '活動類別代碼',
            'type_name' => '活動類別名稱',
            'state' => '活動類別使用狀態',
        ];
    }
}
