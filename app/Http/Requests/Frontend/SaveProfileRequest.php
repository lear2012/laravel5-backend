<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\Http\Requests\Request;

class SaveProfileRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        if(!Auth::user())
//            return false;
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
            'real_name'  => 'required|real_name',
            'id_no' => 'required|id_no',
            'address' => 'max:100',
            'self_get' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'real_name' => '请输入正确的真实姓名',
            'id_no'  => '请输入合法身份证号',
        ];
    }
}
