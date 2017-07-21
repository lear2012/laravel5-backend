<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class ApplyChetieRequest extends Request
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
            'address' => 'required',
            'detail' => 'max:255'
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
            'address.required' => '您必须填写地址信息',
            'detail.max' => '您最多填写255个字符',
        ];
    }

}
