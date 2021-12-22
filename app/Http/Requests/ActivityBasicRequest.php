<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ActivityBasicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }


    protected function defaultRule(): array
    {
        return [
            'activity_type_id' => 'required|integer',
            'theme' => 'required|max:100',
            'description' => 'required|max:400',
            'place' => 'required|max:50',
            'apply_limit' => 'required|numeric|min:0|max:255',
            'apply_state' => 'required|boolean',
        ];
    }

    protected function ruleByPost(): array
    {
        return [
            'apply_sdate' => 'required|date|after:' . Carbon::now(),
            'apply_edate' => 'required|date|after:apply_sdate',
            'sdate' => 'required|date|after:apply_edate',
            'edate' => 'required|date|after:sdate',
        ];
    }

    protected function ruleByPut(): array
    {
        return [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request): array
    {
        $rules = [];
        switch ($request->method) {
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
            'min' => ':attribute最小限制為 :min!',
            'max' => ':attribute最大限制為 :max!',
            'boolean' => ':attribute欄位型別限制為boolean!',
            'after' => ':attribute需於:date之後!',
            'date' => ':attribute欄位型別限制為date!',
        ];
    }

    public function attributes(): array
    {
        return [
            'activity_type_id' => '活動類別',
            'theme' => '活動主題',
            'description' => '活動內容',
            'place' => '活動地點',
            'apply_limit' => '報名人數上限',
            'apply_sdate' => '報名時間起',
            'apply_edate' => '報名時間訖',
            'apply_state' => '報名狀態',
            'sdate' => '活動時間起',
            'edate' => '活動時間訖',
        ];
    }
}
