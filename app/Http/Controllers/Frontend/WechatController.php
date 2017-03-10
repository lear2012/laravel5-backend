<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use ChannelLog as Log;
use EasyWeChat;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use EasyWeChat\Foundation\Application;

class WechatController extends Controller {

    private $openid;

    private $wechatServer;

    private $wechatUser;

    private $wechat;

    public function __construct(Application $wechat){
        //$this->wechatServer = EasyWeChat::server(); // 服务端
        //$this->wechatUser = EasyWeChat::user();
	$this->wechat = $wechat;
    }

    /**
     * 处理微信的请求消息
     *
     * @return string
     */

    function memberList() {
        return view('frontend.member_list', [
            'expDrivers' => User::getExpdrivers(),
            'paidMembers' => User::getPaidMembers()
        ]);
    }

    function memberRegister(Request $request) {
        $wechatUser = session('wechat.oauth_user'); // 拿到授权用户资料
//        $realName = '廖礼林啊';
//        $idNo = '612321198306112612';
//        dd(Utils::verifyIDCard($realName, $idNo));
        if($request->isMethod('post')) {
            $data = $request->all();
            $validator = Validator::make($data, User::$registerRule);
            if($validator->failed()) {
                self::setMsgCode(9001);
            } else {
                if($data['agree'] != 1)
                    self::setMsgCode(1005);
                else if(User::nickUsed($data['nick']))
                    self::setMsgCode(1004);
                else if(User::isRegisterd($data)) {
                    self::setMsgCode(1003);
                } else {
                    if (!User::register($data))
                        self::setMsgCode(1001);
                }
            }
            self::sendJsonMsg();
        }
        // 下单
        $payment = $this->wechat->payment;
        dd($payment);
        return view('frontend.user.register', ['wechatUser' => $wechatUser]);
    }

    function checkImgCode(Request $request) {
        if($request->isMethod('get')) {
            $rules = ['captcha' => 'required|captcha'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                self::setMsgCode(1002);
            }
            self::sendJsonMsg();
        }

    }

    public function profile($id) {
        $user = User::findOrFail($id)->with('profile');
        return view('frontend.user.profile', [
            'user' => $user
        ]);
    }
}
