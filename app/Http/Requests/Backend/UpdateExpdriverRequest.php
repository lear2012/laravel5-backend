<?php
namespace App\Http\Requests\Backend;
use App\Http\Requests\Request;

class UpdateExpdriverRequest extends Request {

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
            'real_name' => 'required|real_name',
            'mobile' => 'required|numeric',
            'keye_age' => 'digits_between:1,100',
        ];
    }

}
