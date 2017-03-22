<?php
namespace App\Http\Controllers\Frontend;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\UserProfile;
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
use Session;
use PHPHtmlParser\Dom;
use Pinyin_Pinyin;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverBy;


class WechatController extends Controller {

    private $openid;

    private $vehicleInfoUrl = 'http://carport.fblife.com/view/type';

    private $vehicleInfoUrl2 = 'http://www.autohome.com.cn/suv/#pvareaid=103421';
    public function __construct(Application $wechat){
        parent::__construct($wechat);
    }

    /**
     * 处理微信的请求消息
     *
     * @return string
     */

    function memberList() {
        $wechatUser = session('wechat.oauth_user');
        $user = User::isWechatRegisterUser();
        $user = $user ? $user : $wechatUser;
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
                } else if(!$this->checkSmsCode($data['mb_verify_code'])) {
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

    public function checkSmsCode($code) {
	if(empty(Session::get('_register_code')))
            return false;
        return strtoupper(Session::get('_register_code')) == strtoupper($code);
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
                try {
                    // 指定该单用户为付费用户
                    $profile = UserProfile::where('wechat_id', $order->wechat_openid)->first();
                    $user = User::find($profile->user_id);
                    $user->roles()->attach(config('custom.paid_member_code'));
                } catch(Exception $e) {
                    Log::write('common', 'Set user to paid user failed for oid:'.$order->oid);
                }
            } else {
                Log::write('wechat', 'Get notify error!');
            }
            $order->save();
            return true;
        });
        return $response;
    }

    public function sendSms(Request $request) {
        Log::write('sms', 'Get params:'.http_build_query($request->all()));
        if($request->isMethod('get')) {
            $rules = ['mobile' => 'required|mobile'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                self::setMsgCode(1002);
            }
            // generate the code
            $code = strtoupper(str_random(5));
	        Session::put('_register_code', $code);
	        Session::save();
	        Utils::sendSms($request->get('mobile'), ['code' => $code], env('ALIYUN_LEAR_SMS_TEMPLATE_CODE'));
            self::sendJsonMsg();
        }
    }

    public function memberPay(Request $request) {
        Log::write('wechat', 'Get member pay with params:'.http_build_query($request->all()));
    }

    public function vehicleInfoCrawler() {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $data = []; // 所有车辆数据
        $carInfo = '/tmp/carInfo.html';
        $content = '';
        $host = 'http://keye.local.com:4444/wd/hub'; // this is the default
        //putenv("webdriver.chrome.driver=/Users/liaolliso/Downloads/chromedriver");
        putenv("webdriver.chrome.driver=/Applications/Google\ Chrome.app/Contents/MacOS/Google\ Chrome");
        $capabilities = DesiredCapabilities::chrome();
        $driver = RemoteWebDriver::create($host, $capabilities, 0, 0);
        if(!file_exists($carInfo)) {
            // navigate to 'http://docs.seleniumhq.org/'
            $driver->get($this->vehicleInfoUrl2);
            $driver->wait(10)->until(
                WebDriverExpectedCondition::presenceOfAllElementsLocatedBy(
                    WebDriverBy::className('uibox')
                )
            );
            $content = $driver->getPageSource();
            file_put_contents($carInfo, $content);
//            // close the Chrome
//            $driver->quit();
        } else
            $content = file_get_contents($carInfo);
        if($content == '')
            return false;

        $dom = new Dom;
        $dom->load($content, [
            'enforceEncoding' => 'gb2312',
            'whitespaceTextNode' => false,
            //'cleanupInput' => false
        ]);
        $nodeValues = $dom->find('div#tab-content .rank-list > dl > dd');
        //var_dump(count($nodeValues));exit;
        try {
            foreach ($nodeValues as $item) {
                //dd($item->innerHtml);
                //dd($item);
                $brand = $item->firstChild()->firstChild()->text();
                $dataNode = $item->firstChild()->nextSibling();
                $children = $dataNode->getChildren();
                Log::write('common', 'access brand:'.$brand);
                // deal with brand
                $brandItem = [];
                $brandItem['capital'] = strtoupper(Utils::getStrFirstChar($brand));
                $brandItem['name'] = $brand;
                $brandItem['code'] = md5($brand);
                $brandItem['series'] = [];
                foreach ($children as $li) {
                    if($li->innerHtml == '') {
                        continue;
                    }
                    $series = $li->firstChild()->text(true);  // 车系
                    $detailUrl = $li->firstChild()->firstChild()->href; // 车系url
                    $fileName = '/tmp/series/' . str_slug($series) . '.html'; // 保存该车系详情页
                    Log::write('common', 'access series:'.$series);
                    $seriItem = [];
                    $seriItem['name'] = $series;
                    $seriItem['code'] = md5($series);
                    $seriItem['styles'] = [];

                    if (!file_exists($fileName)) {
                        // navigate to detail
                        $driver->get($detailUrl);
                        $driver->wait(10)->until(
                            WebDriverExpectedCondition::presenceOfAllElementsLocatedBy(
                                WebDriverBy::tagName('body')
                            )
                        );
                        $content = $driver->getPageSource();
                        //$content = file_get_contents($detailUrl);
                        file_put_contents($fileName, $content);
                    } else
                        $content = file_get_contents($fileName);
                    // deal with content
                    $dom->load($content, [
                        'enforceEncoding' => 'gb2312',
                        'whitespaceTextNode' => false,
                        //'cleanupInput' => false
                    ]);
                    $nds = $dom->find('.tab-ys .current .interval01-list .interval01-list-cars');
                    $tds = $dom->find('td.name_d');
//                    $alert = $dom->find('.alert-con');
//                    if(count($alert) > 0) {
//                        Log::write('common', 'no access style for serires:'.$series);
//                        continue;
//                    }
                    // 处理车型
                    foreach ($nds as $styleLi) {
                        if($styleLi->innerHtml == '') {
                            continue;
                        }
                        $style = $styleLi->firstChild()->firstChild()->text(true);
                        Log::write('common', 'access style:'.$style);
                        if (!in_array($style, $seriItem['styles']))
                            $seriItem['styles'][] = $style;
                    }
                    foreach ($tds as $styleLi) {
                        if($styleLi->innerHtml == '') {
                            continue;
                        }
                        $style = $styleLi->firstChild()->text(true);
                        Log::write('common', 'access style:'.$style);
                        if (!in_array($style, $seriItem['styles']))
                            $seriItem['styles'][] = $style;
                    }
                    $brandItem['series'][] = $seriItem;
                }
                $data[] = $brandItem;
            }
        } catch(Exception $e) {
            throw new $e;
        }
        // close the chrome
        $driver->quit();
        file_put_contents('/tmp/carInfo.json', json_encode($data));
    }

    public function getBrands() {

    }

    public function getBrandSeries(Request $request) {

    }
}

