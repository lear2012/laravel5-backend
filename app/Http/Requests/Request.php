<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

abstract class Request extends FormRequest {

	//
    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

    public function response(array $errors)
    {
        $errMsg = $this->getValidatorInstance()->errors()->getMessages();
        $firstKey = '';
        $firstMsg = '';
        foreach($errMsg as $k => $msg) {
            $firstKey = $k;
            $firstMsg = $msg;
            break;
        }
        $codes = $this->getErrMsgCode();
        return response()->json(['errno'=>$codes[$firstKey],'msg'=>$firstMsg]); // i wanted the Message to be a string
    }

    public function getErrMsgCode() {
        return [
            'real_name' => 10001,
            'id_no' => 10002,
            'brand' => '10003',
        ];
    }
}
