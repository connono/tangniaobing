<?php

namespace App\Http\Requests\Api;

class ComplicationRequest extends FormRequest
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
                ];
                break;
            case 'PATCH':
                return [
                    'id' => 'required|integer',
                    'name' => 'required|string',
                ];
                break;
            case 'DELETE':
                return [
                    'id' => 'required|integer',
                ];
            case 'GET':
                return [
                    'id' => 'integer'
                ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => '名称不能为空',
        ];
    }  
}
