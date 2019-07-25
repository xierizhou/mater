<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChannelRequest extends FormRequest
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
            "name"=>"required",
            "alias_name"=>"required",
            "domain"=>"required",
        ];
    }

    /**
     * Show Error Message
     *
     * @return array
     */
    public function messages()
    {
        return [
            "name.required"=>"渠道名称必填字段",
            "alias_name.required"=>"别名必填字段",
            "domain.required"=>"渠道地址必填字段",
        ];
    }
}
