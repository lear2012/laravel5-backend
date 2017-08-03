<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class SectionSelfRegRequest extends Request
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
            'name' => 'required|max:255',
            'mobile' => 'required|mobile',
            'section_id' => 'required|numeric'
            //'brand' => 'required|max:255',
            //'wechat_no' => 'required'
        ];
    }

    public function messages()
    {
        return  [
            'name.required' => '必须填写姓名',
            'mobile.required' => '必须填写手机号',
            'section_id.required' => '必须有路段id',
            'section_id.numeric' => '路段id必须是数字',
        ];
    }

}
