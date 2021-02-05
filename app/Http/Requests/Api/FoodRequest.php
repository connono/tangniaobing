<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

class FoodRequest extends FormRequest
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
                    'name' => 'required|string',
                    'gi' => 'required|string',
                    'energy' => 'required|integer',
                    'carbohydrate' => 'required|integer',
                    'axunge' => 'required|integer',
                    'protein' => 'required|integer',
                ];
                break;
            case 'PATCH':
                return [
                    'id' => 'required|integer',
                    'name' => 'required|string',
                    'gi' => 'required|string',
                    'energy' => 'required|integer',
                    'carbohydrate' => 'required|integer',
                    'axunge' => 'required|integer',
                    'protein' => 'required|integer',
                ];
                break;
            case 'DELETE':
                return [
                    'id' => 'required|integer',
                ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => '名称不能为空',
            'gi.required' => 'GI不能为空',
            'energy.required' => '能量不能为空',
            'carbohydrate.required' => '碳水化合物含量不能为空',
            'axunge.required' => '脂肪含量不能为空',
            'protein.required' => '蛋白质含量不能为空'
        ];
    }   
}
