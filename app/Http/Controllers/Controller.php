<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use EasyWeChat\Foundation\Application;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $wechat;

    protected $js;

    public function __construct(Application $wechat){
        $this->wechat = $wechat;
        $this->js = $this->wechat->js;
    }

    public static $ret = [
        'errno' => 0,
        'msg' => '',
        'data' => ''
    ];

    public static function sendJsonMsg() {
        echo json_encode(self::$ret);exit;
    }

    public static function setMsgCode($code) {
        self::$ret['errno'] = $code;
        self::$ret['msg'] = self::$msgs[$code];
    }

    public static function setData($data) {
        self::$ret['data'] = $data;
    }

    public static $msgs = [

        1001 => '注册失败，请刷新页面重试！',
        1002 => '图片验证码校验失败！',
        1003 => '该手机号已经被注册！',
        1004 => '该用户名已经被注册!',
        1005 => '您必须同意会员规则！',
        1006 => '您输入的短信验证码有误！',
        1007 => '',

        9001 => '参数错误',
        9002 => '未知错误',
        9003 => '未找到该对象',
    ];
}
