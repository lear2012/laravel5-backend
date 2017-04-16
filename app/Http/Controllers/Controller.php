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

    protected $notice;

    protected $wechatUser;

    protected $js;

    public function __construct(Application $wechat){
        $this->wechat = $wechat;
        $this->wechatUser = session('wechat.oauth_user');
        $this->js = $this->wechat->js;
        $this->notice = $this->wechat->notice;
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
        self::sendJsonMsg();
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
        1007 => '保存用户信息失败',
        1008 => '您今天的实名认证次数超过3次，请明天重试!',
        1009 => '您今天发送验证短信次数超过三次，请明天重试!',
        1010 => '您输入的邀请码无效，请联系邀请人！',
        1011 => '实名认证失败，请重试!',
        1012 => '该身份证号已经认证通过！',
        1013 => '目前您的会员编号只能申请001-150之间的三位数字',
        1014 => '该会员编号已经被他人申请，请选择其它001-150之间的数字',
        1015 => '您上传的图片不能超过9张！',

        9001 => '参数错误',
        9002 => '未知错误',
        9003 => '未找到该对象',
    ];
}
