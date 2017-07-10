<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class LiftRegRequest extends Request
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
            'agree' => 'required|boolean'
        ];
    }

    public function messages()
    {
        return  [
            'enrollment_id.required' => '必须选择一辆您要搭的车辆',
            'enrollment_id.numeric' => '车辆ID必须是数字',
            'name.required' => '必须填写姓名',
            'mobile.required' => '必须填写正确的手机号',
            'agree.required' => '必须同意报名协议内容方能报名',
        ];
    }

}
