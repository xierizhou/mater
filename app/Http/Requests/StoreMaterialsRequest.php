<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialsRequest extends FormRequest
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
            'name'=>'required',
            'domain'=>'required',
        ];
    }

    /**
     * Show Message
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'=>'网站素材名称必填字段',
            'domain.required'=>'网站素材URL必填字段',
            'domain.url'=>'URL不是有效的URL'
        ];
    }
}
