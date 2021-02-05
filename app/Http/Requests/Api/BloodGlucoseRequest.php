<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

class BloodGlucoseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method()) {
            case 'POST':
                return [
                    'type' => [
                        'required',
                        Rule::in([0, 1, 2, 3, 4, 5])
                    ],
                    'blood_glucose' => 'required' 
                ];
                break;
            case 'GET':
                return [
                    'type' => [
                        'required',
                        Rule::in([0, 1, 2, 3, 4, 5])
                    ]
                ];
        }
    }

    public function messages()
    {
        return [
            'type.required' => '类型不能为空',
            'blood_glucose.required' => '血糖情况不能为空',
        ];
    }
}
