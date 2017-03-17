<?php
namespace App\Http\Controllers\Frontend;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use ChannelLog as Log;
use EasyWeChat;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as JavaScript;
use Auth;
use GuzzleHttp;

class WechatController extends Controller {

    private $openid;

    public function __construct(Application $wechat){
        parent::__construct($wechat);
    }

    /**
     * 处理微信的请求消息
     *
     * @return string
     */

    function memberList() {
        $user = User::isWechatRegisterUser();
        $user = $user ? $user : Auth::user();
        $expDrivers = User::getExpdrivers();
        $paidMembers = User::getPaidMembers();
        JavaScript::put([
            'expDrivers' => $expDrivers,
            'paidMembers' => $paidMembers
        ]);
        return view('frontend.member_list', [
            'expDrivers' => $expDrivers,
            'paidMembers' => $paidMembers,
            'loginUser' => $user
        ]);
    }

    function memberRegister(Request $request) {
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
                } else if($this->checkSmsCode($data['mb_verify_code'])) {
                    self::setMsgCode(1006);
                } else {
                    // register the user
                    $user = User::register($data);
		            if (!$user)
                        self::setMsgCode(1001);
                    // login the user
                    Auth::login($user);
                }
            }
            self::sendJsonMsg();
        }
        // 如果该微信用户已经注册过，则登陆该用户并跳转至会员列表页
        if(User::isWechatRegisterUser()) {
            return redirect()->route('wechat.member_list');
        }
        $config = []; // 支付配置信息
        $wechatUser = session('wechat.oauth_user'); // 拿到授权用户资料
        if(!$wechatUser) {
            abort(404);
        }
        // 下单, 若该用户已经有注册订单，则忽略
        Log::write('common', 'Wechat User:'.$wechatUser->nickname.', openid:'.$wechatUser->id.' not registered, set payconfig now');
        $order = User::setRegisterOrder();
        if(!empty($order)) {
            $o = new Order($order);
            $payment = $this->wechat->payment;
            $result = $payment->prepare($o);
            if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
                $config = $payment->configForJSSDKPayment($result->prepay_id);
                Log::write('wechat', 'Get pay config with params:'.http_build_query($config));
            }
        }
        JavaScript::put([
            'config' => $config,
        ]);
        return view('frontend.user.register', [
            'wechatUser' => $wechatUser,
            'js' => $this->js
        ]);
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

    function checkSmsCode($code) {
        if(empty(session('_register_code')))
            return false;
        return session('_register_code') == $code;
    }

    public function profile($id) {
        $user = User::where([
            'uid' => $id
        ])->first();
        if(!$user) {
            abort(404);
        }
        return view('frontend.user.profile', [
            'user' => $user
        ]);
    }

    public function notify(Request $request) {
//        $str = file_get_contents('php://input');
//        Log::write('wechat', 'Get notify string:'.$str);
        $payment = $this->wechat->payment;
        $response = $payment->handleNotify(function($notify, $successful){
            //Log::write('wechat', 'Get notified with params:'.http_build_query(get_object_vars($notify)));
            $order = \App\Models\Order::where('oid', '=', $notify->out_trade_no)->first();
            if(!$order) {
                return 'Order not found';
            }
            if ($order->pay_at) { // 假设订单字段“支付时间”不为空代表已经支付
                return 'Order already paid'; // 已经支付成功了就不再更新了
            }
            if($successful) {
                // 成功后更新订单状态
                $order->pay_at = time();
                $order->status = 2;
            } else {

            }
            $order->save();
            return true;
        });
        return $response;
    }

    public function sendSms(Request $request) {
        Log::write('wechat', 'Get params:'.http_build_query($request->all()));
        if($request->isMethod('get')) {
            $rules = ['mobile' => 'required|mobile'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                self::setMsgCode(1002);
            }
            // generate the code
            $code = str_random(5);
            session('_register_code', $code);
            Utils::sendSms($request->get('mobile'), ['code' => $code], 'SMS_54855001');
            self::sendJsonMsg();
        }
    }

    public function memberPay(Request $request) {
        Log::write('wechat', 'Get member pay with params:'.http_build_query($request->all()));
    }

    public function vehicleInfoCrawler() {

    }
}

