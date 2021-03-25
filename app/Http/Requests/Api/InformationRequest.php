<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

class InformationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'sex' => [
                'required',
                Rule::in(['0','1'])
            ],
            'height' => 'required|integer',
            'age' => 'required|integer',
            'weight' => 'required|integer',
            'complication' => 'required|string',
            'profession' => 'required|string',
            'sports' => [
                'required',
                Rule::in(['1','2','3'])
            ],
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'sex.required' => '性别不能为空',
            'height.required' => '身高不能为空',
            'age.required' => '年龄不能为空',
            'weight.required' => '体重不能为空',
            'complication.required' => '合并症不能为空',
            'profession.required' => '年龄不能为空',
            'sports.required' => '运动情况不能为空',
        ];
    }
}
