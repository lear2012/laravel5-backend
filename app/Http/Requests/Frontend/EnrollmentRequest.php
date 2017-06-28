<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentRequest extends Request
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
            'start' => 'required',
            'end' => 'required',
            //'wechat_no' => 'required'
        ];
    }

    public function messages()
    {
        return  [
            'name.required' => '必须填写姓名',
            'mobile.required' => '必须填写手机号',
            'start.required' => '必须填写起点',
            'end.required' => '必须填写终点',
            //'wechat_no.required' => '必须填写微信号',
        ];
    }

}
