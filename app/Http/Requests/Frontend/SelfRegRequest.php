<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class SelfRegRequest extends Request
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
            'brand' => 'required|max:255',
            'start' => 'required|max:255',
            'end' => 'required|max:255',
            'available_seats' => 'numeric',
            'agree' => 'required|boolean'
            //'wechat_no' => 'required'
        ];
    }

    public function messages()
    {
        return  [
            'name.required' => '必须填写姓名',
            'mobile.required' => '必须填写手机号',
            'brand.required' => '必须填写您的车型',
            'start.required' => '必须选择起点',
            'end.required' => '必须选择终点',
            'available_seats.numeric' => '搭载人数必须是数字',
            'agree.required' => '必须同意协议内容方能报名',
        ];
    }

}
