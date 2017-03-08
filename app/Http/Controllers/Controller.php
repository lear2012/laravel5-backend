<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static $ret = [
        'errno' => 0,
        'msg' => '',
        'extra' => ''
    ];

    public static function sendJsonMsg() {
        echo json_encode(self::$ret);exit;
    }

    public static function setMsgCode($code) {
        self::$ret['errno'] = $code;
        self::$ret['msg'] = self::$msgs[$code];
    }

    public static $msgs = [

        1001 => '注册失败，请刷新页面重试！',
        1002 => '图片验证码校验失败！',
        1003 => '该手机号已经被注册！',
        1004 => '该用户名已经被注册!',
        1005 => '您必须同意会员规则！',

        9001 => '参数错误',
        9002 => '未知错误',
    ];
}