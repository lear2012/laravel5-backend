<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class LiftCreateRequest extends Request
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
            'enrollment_id' => 'required|numeric',
            'name' => 'required|max:255',
            'mobile' => 'required|mobile',
            //'wechat_no' => 'required'
        ];
    }

    public function messages()
    {
        return  [
            'enrollment_id.required' => '必须选择一个搭载车辆',
            'name.required' => '必须填写姓名',
            'mobile.required' => '必须填写手机号',
            //'wechat_no.required' => '必须填写微信号',
        ];
    }

}
