<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

abstract class HttpRequest extends FormRequest {

	//
    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

    public function getErrMsgCode() {
        return [
            'real_name' => 10001,
            'id_no' => 10002,
            'brand' => '10003',
            'title' => '10004',
            'start' => '10005',
            'end' => '10006',
            'votes' => '10007',

        ];
    }
}
