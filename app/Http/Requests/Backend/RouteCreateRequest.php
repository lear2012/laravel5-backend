<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\HttpRequest;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class RouteCreateRequest extends HttpRequest
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
            'title' => 'required|max:255',
            'start' => 'required',
            'end' => 'required',
            'votes' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return  [
            'title.unique' => '“路线标题”已存在',
            'title.required' => '必须填写“路线标题”',
            'start.required' => '必须填写起点',
            'end.required' => '必须填写终点',
            'votes.required' => '必须填写围观数',
            'votes.numeric' => '围观数必须是数字',
        ];
    }

}
