<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\LimitedOp;
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
use App\Models\Brand;
use App\Models\Sery;
use App\Models\Motomodel;
use DB;
use App\Http\Requests\Frontend\SaveProfileRequest;
//use App\Events\MemberFeePaid;
use Image;

class WechatController extends Controller
{

    private $openid;

    private $vehicleInfoUrl = 'http://carport.fblife.com/view/type';

    private $vehicleInfoUrl2 = 'http://www.autohome.com.cn/suv/#pvareaid=103421';

    public function __construct(Application $wechat)
    {
        parent::__construct($wechat);
    }

    /**
     * 处理微信的请求消息
     *
     * @return string
     */

    function memberList()
    {
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
            'loginUser' => $user,
            'wechatUser' => $wechatUser
        ]);
    }

    function joinClub()
    {
        $wechatUser = session('wechat.oauth_user');
        $brands = $this->getBrands();
        JavaScript::put([
            'brands' => $brands,
        ]);
        return view('frontend.user.join_club', [
            'wechatUser' => $wechatUser,
        ]);
    }

    function memberRegister(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $validator = Validator::make($data, User::$registerRule);
            if ($validator->failed()) {
                self::setMsgCode(9001);
            } else {
                if ($data['agree'] != 1)
                    self::setMsgCode(1005);
                else if (User::nickUsed($data['nick']))
                    self::setMsgCode(1004);
                else if (User::isRegisterd($data)) {
                    self::setMsgCode(1003);
                } else if (isset($data['invite_no']) && !empty($data['invite_no']) && !Invitation::codeValid($data['invite_no'])) {
                        self::setMsgCode(1010);
                } else if (!$this->checkSmsCode($data['mb_verify_code'])) {
                    self::setMsgCode(1006);
                } else {
                    // register the user
                    $user = User::register($data);
                    if (!$user)
                        self::setMsgCode(1001);
                    // login the user
                    self::setData((string)$user->uid);
                    Auth::login($user, true);
                }
            }
            self::sendJsonMsg();
        }
        // 如果该微信用户已经注册过，则登陆该用户并跳转至会员列表页
        if (User::isWechatRegisterUser()) {
            return redirect()->route('wechat.member_list');
        }
        $config = []; // 支付配置信息
        $wechatUser = session('wechat.oauth_user'); // 拿到授权用户资料
        if (!$wechatUser) {
            abort(404);
        }
        // 如果没有单，则下单，如果有单，则返回单
        Log::write('common', 'Wechat User:' . $wechatUser->nickname . ', openid:' . $wechatUser->id . ' not registered, set payconfig now');
        $order = User::setRegisterOrder();
        Log::write('wechat', 'Get order params:' . http_build_query($order));
        if (!empty($order) && empty($order['pay_config'])) {
            $o = new Order($order);
            $payment = $this->wechat->payment;
            $result = $payment->prepare($o);
            if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
                $config = $payment->configForJSSDKPayment($result->prepay_id);
                $dbOrder = \App\Models\Order::where('oid', '=', $order['out_trade_no'])->first();
                $dbOrder->pay_config = serialize($config);
                $dbOrder->save();
                Log::write('wechat', 'Get pay config with params:' . http_build_query($config));
            }
        } else if(!empty($order['pay_config'])) {
            // 直接获取订单的pay_config
            $config = unserialize($order['pay_config']);
        }

        JavaScript::put([
            'config' => $config,
        ]);
        return view('frontend.user.register', [
            'wechatUser' => $wechatUser,
            'js' => $this->js
        ]);
    }

    public function getInvitationPayconfig(Request $request) {
        $data = $request->only('code');
        if(trim($data['code']) == '') {
            self::setMsgCode(9001);
        }
        if(!Invitation::codeValid($data['code']))
            self::setMsgCode(1010);
        $config = [];
        $order = User::setRegisterOrder($data);
        if (!empty($order)) {
            $o = new Order($order);
            $payment = $this->wechat->payment;
            $result = $payment->prepare($o);
            if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
                $config = $payment->configForJSSDKPayment($result->prepay_id);
                $dbOrder = \App\Models\Order::where('oid', '=', $order['out_trade_no'])->first();
                $dbOrder->pay_config = serialize($config);
                $dbOrder->save();
                Log::write('wechat', 'Get pay config with params:' . http_build_query($config));
            }
        }
        self::setData($config);
        self::sendJsonMsg();
    }

    function checkImgCode(Request $request)
    {
        if ($request->isMethod('get')) {
            $rules = ['captcha' => 'required|captcha'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                self::setMsgCode(1002);
            }
            self::sendJsonMsg();
        }

    }

    public function checkSmsCode($code)
    {
        if (empty(Session::get('_register_code')))
            return false;
        return strtoupper(Session::get('_register_code')) == strtoupper($code);
    }

    public function profile($id)
    {
        $user = User::where([
            'uid' => $id
        ])->first();
        if (!$user) {
            abort(404);
        }
        $carImgs = $user->profile->car_imgs ? explode(',', $user->profile->car_imgs) : [];
        return view('frontend.user.profile', [
            'user' => $user,
            'carImgs' => $carImgs
        ]);
    }

    public function editProfile(Request $request)
    {
        $id = $request->get('id');
        //Log::write('common', 'Uid compare:' .Auth::user()->uid.'=='.$id );
        if(!Auth::user() || Auth::user()->uid != $id) {
            abort(401);
        }
        $config = []; // 支付配置信息
        $paying = $request->get('paying');
        $wechatUser = session('wechat.oauth_user'); // 拿到授权用户资料
        $userIsRegister = Auth::user()->hasRole('register_member');
        $user = User::where([
            'uid' => $id
        ])->first();
        if (!$user) {
            abort(404);
        }
        $brands = $this->getBrands();
        if($userIsRegister) {
            // 如果是注册会员，需要有支付会费的config
            $order = User::setRegisterOrder(['force' => true]); // 强制重新生成订单
            Log::write('wechat', 'Get order params:' . http_build_query($order));
            // 如果订单的pay_config为空，或者如果该注册会员邀请码已经使用则重新生成订单支付配置
            if ((!empty($order) && empty($order['pay_config'])) || (!empty($user->profile->invite_no) && !Invitation::codeValid($user->profile->invite_no))) {
                $o = new Order($order);
                $payment = $this->wechat->payment;
                $result = $payment->prepare($o);
                if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
                    $config = $payment->configForJSSDKPayment($result->prepay_id);
                    Log::write('wechat', 'Get pay config with params:' . http_build_query($config));
                }
            } else if (!empty($order['pay_config'])) {
                // 直接获取订单的pay_config
                $config = unserialize($order['pay_config']);
            }
        }
        JavaScript::put([
            'brands' => $brands,
            'config' => $config,
            'userIsRegister' => $userIsRegister
        ]);
        return view('frontend.user.edit_profile', [
            'user' => $user,
            'js' => $this->js
        ]);
    }

    public function saveProfile(SaveProfileRequest $request) {
        $data = $request->only('real_name', 'id_no', 'vehicle', 'brand', 'sery', 'buy_year', 'car_no', 'self_get', 'member_no', 'address', 'quotation', 'invite_no', 'car_imgs');
        $data['series'] = $data['sery'];
        unset($data['sery']);
        Log::write('common', 'Get params:'.http_build_query($data));
        // check if member_no exist
        if(isset($data['member_no']) && !empty($data['member_no'])) {
            if (!is_numeric($data['member_no']) || strlen($data['member_no']) > 3 || (int)$data['member_no'] <= 0 || (int)$data['member_no'] > 150)
                self::setMsgCode(1013);
            $data['member_no'] = str_pad($data['member_no'], 3, "0", STR_PAD_LEFT);
            $data['member_no'] = config('custom.KY_MEMBER_NO_PREFIX') . $data['member_no'];
            $userProfile = UserProfile::where('member_no', '=', $data['member_no'])->where('user_id', '!=', Auth::user()->id)->first();
            if ($userProfile)
                self::setMsgCode(1014);
        }
        $userProfile = Auth::user()->profile;
        if(Auth::user()->vehicle == $data['vehicle']) {
            // 不更新车辆信息
            unset($data['brand']);
            unset($data['series']);
        }
        if($data['buy_year'] == '')
            unset($data['buy_year']);
        // check if current user is id verified in db
        if($userProfile->is_verified != 1) {
            // check how many times does this user apply for verification
            if(User::getActionCount(Auth::user()->uid, 'id_card_verify') >= config('custom.ID_CARD_VERIFY_DAY_ALLOW') ) {
                self::setMsgCode(1008);
            }
            // verify the user
            $result = Utils::verifyIDCard($data['real_name'], $data['id_no']);
            $data['is_verified'] = $result->isok ? 1 : 0;
            // record action
            User::recordLimitAction(Auth::user()->uid, config('custom.limited_ops.id_card_verify'));
            if($data['is_verified'] == 0) {
                self::setMsgCode(1011);
            }
        }
        // if no images
        if(!isset($data['car_imgs']) || $data['car_imgs'] == '')
            unset($data['car_imgs']);
        // save profile info
        $userProfile->fill($data);
        if(!$userProfile->save()) {
            self::setMsgCode(1007);
        }
        Log::write('common', 'Update profile for user:'.Auth::user()->uid);
        self::setData((string)Auth::user()->uid);
        self::sendJsonMsg();
    }

    public function notify(Request $request)
    {
//        $str = file_get_contents('php://input');
//        Log::write('wechat', 'Get notify string:'.$str);
        $payment = $this->wechat->payment;
        $response = $payment->handleNotify(function ($notify, $successful) {
            //Log::write('wechat', 'Get notified with params:'.http_build_query(get_object_vars($notify)));
            $order = \App\Models\Order::where('oid', '=', $notify->out_trade_no)->first();
            if (!$order) {
                return 'Order not found';
            }
            if ($order->pay_at) { // 假设订单字段“支付时间”不为空代表已经支付
                return 'Order already paid'; // 已经支付成功了就不再更新了
            }
            if ($successful) {
                // 成功后更新订单状态
                $order->pay_at = time();
                $order->status = 2;
                try {
                    // 指定该单用户为付费用户
                    $profile = UserProfile::where('wechat_id', $order->wechat_openid)->first();
                    $user = User::find($profile->user_id);
                    $user->roles()->detach(config('custom.register_member_code'));
                    $user->roles()->attach(config('custom.paid_member_code'));
                    // check if this user has invite number
                    $inviteNo = $profile->invite_no;
                    if(!empty($inviteNo)) {
                        // 更新邀请码状态
                        $invite = Invitation::where('invitation_code', '=', $inviteNo)->first();
                        $invite->invited_user_id = $user->id;
                        $invite->used = 1;
                        $invite->save();
                    }
                    // check to see if we can send him invitation codes
                    $paidMemberCount = User::getPaidMemberCount();
                    if($paidMemberCount <= config('custom.top_discount_user_count')) {
                        // check if the user has $c invitation codes
                        $codeCount = Invitation::where('user_id', '=', $user->id)->count();
                        if($codeCount == 0) {
                            // generate the invitation codes for the users
                            Invitation::generateInvitationCodes(3, $codes, $user->id);
                            Log::write('common', 'Generated invitation codes for '.$user->id.':'.implode(',', $codes));
                            $messageId = $this->notice->send([
                                'touser' => $order->wechat_openid,
                                'template_id' => config('custom.MEMBER_INVITATION_CODES_TEMPLATE_ID'),
                                'url' => '',
                                'data' => [
                                    "first"  => "欢迎成为可野Club付费会员!",
                                    "UID"   => $user->username,
                                    "CtripCode"  => implode(", ", $codes),
                                    "Remark" => "您可以将邀请码发送给您的朋友，使用该邀请码的朋友只需付1元即可成为可野人，一个邀请码仅可使用一次！",
                                ],
                            ]);
                            Log::write('common', 'Send notice invitation codes for '.$user->id.':'.implode(',', $codes).' with messageid:'.$messageId);
                            //event(new MemberFeePaid($user, $codes));
                        }
                    }
                } catch (Exception $e) {
                    Log::write('common', 'Set user to paid user failed for oid:' . $order->oid);
                }
            } else {
                Log::write('wechat', 'Get notify error!');
            }
            $order->save();
            return true;
        });
        return $response;
    }

    public function sendSms(Request $request)
    {
        Log::write('sms', 'Get params:' . http_build_query($request->all()));
        if ($request->isMethod('get')) {
            $rules = ['mobile' => 'required|mobile'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                self::setMsgCode(1002);
            }
            $wechatUser = session('wechat.oauth_user');
            // check how many times does this user apply for sms
            if(User::getActionCount($wechatUser->id, 'sms_register') >= config('custom.SMS_REGISTER_VERIFY_DAY_ALLOW') ) {
                self::setMsgCode(1009);
                self::sendJsonMsg();
            }
            if (!empty(Session::get('_reg_sms_expires')) && time() < Session::get('_reg_sms_expires')) {
                // 如果30分钟内请求，则返回
                $code = Session::get('_register_code');
            } else {
                // generate the code
                $code = strtoupper(rand(1000,9999));
                Session::put('_register_code', $code);
                $lifetime = time() + 60 * 30; // one year
                Session::put('_reg_sms_expires', $lifetime);
                Session::save();
            }
            Utils::sendSms($request->get('mobile'), ['code' => $code], env('ALIYUN_LEAR_SMS_TEMPLATE_CODE'));
            // record action
            User::recordLimitAction($wechatUser->id, config('custom.limited_ops.sms_register'));
            self::sendJsonMsg();
        }
    }

    public function memberPay(Request $request)
    {
        Log::write('wechat', 'Get member pay with params:' . http_build_query($request->all()));
    }

    public function vehicleInfoCrawler()
    {
        return false;
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
        if (!file_exists($carInfo)) {
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
        if ($content == '')
            return false;

        $dom = new Dom;
        $dom->load($content, [
            'enforceEncoding' => 'gb2312',
            'whitespaceTextNode' => false,
            //'cleanupInput' => false
        ]);
        $nodeValues = $dom->find('div#tab-content .rank-list > dl');
        $uniqeBrands = [];
        try {
            foreach ($nodeValues as $item) {
                $brandNode = $item->firstChild()->firstChild()->nextSibling();
                //dd($brandNode->firstChild()->href);
                //dd($brandNode->text(true));
                $brand = $brandNode->text(true);
                if (!in_array($brand, $uniqeBrands))
                    $uniqeBrands[] = $brand;
                else
                    continue;
                $dataNode = $item->firstChild()->nextSibling();
                $seriesHtml = $dataNode->innerHtml;
                $dom->load($seriesHtml, [
                    'enforceEncoding' => 'gb2312',
                    'whitespaceTextNode' => false,
                    //'cleanupInput' => false
                ]);
                $children = $dom->find('h4');
                Log::write('common', 'access brand:' . $brand);
                // deal with brand
                $brandItem = [];
                $brandItem['capital'] = strtoupper(Utils::getStrFirstChar($brand));
                $brandItem['name'] = $brand;
                $brandItem['code'] = md5($brand);
                $brandItem['series'] = [];
                foreach ($children as $li) {
                    if ($li->innerHtml == '') {
                        continue;
                    }
                    $series = $li->firstChild()->text(true);  // 车系
                    $detailUrl = $li->firstChild()->href; // 车系url

                    $fileName = '/tmp/series/' . md5($series) . '.html'; // 保存该车系详情页
                    Log::write('common', 'access series:' . $series);
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
                    $nds = $dom->find('.tab-ys .interval01-list .interval01-list-cars');
                    $tds = $dom->find('.name_d');
//                    $alert = $dom->find('.alert-con');
//                    if(count($alert) > 0) {
//                        Log::write('common', 'no access style for serires:'.$series);
//                        continue;
//                    }
                    // 处理车型
                    foreach ($nds as $styleLi) {
                        if ($styleLi->innerHtml == '') {
                            continue;
                        }
                        $style = $styleLi->firstChild()->firstChild()->text(true);
                        Log::write('common', 'access style:' . $style);
                        if (!in_array($style, $seriItem['styles']))
                            $seriItem['styles'][] = $style;
                    }
                    foreach ($tds as $styleLi) {
                        if ($styleLi->innerHtml == '') {
                            continue;
                        }
                        $style = $styleLi->firstChild()->text(true);
                        Log::write('common', 'access style:' . $style);
                        if (!in_array($style, $seriItem['styles']))
                            $seriItem['styles'][] = $style;
                    }
                    $brandItem['series'][] = $seriItem;
                }
                $data[] = $brandItem;
            }
        } catch (Exception $e) {
            throw new $e;
        }
        // close the chrome
        $driver->quit();
        file_put_contents('/tmp/carInfo.json', json_encode($data));
    }

    public function getBrands()
    {
        $brandList = Brand::getActiveBrands();
        $data = [];
        foreach ($brandList as $item) {
            $firstChar = $item->firstchar;
            if (!isset($data[$firstChar])) {
                $data[$firstChar] = [];
            }
            $data[$firstChar][] = $item;
        }
        ksort($data);
        return $data;
    }

    public function getSeries($code)
    {
        if(!$code) {
            self::setMsgCode(9001);
            self::sendJsonMsg();
        }
        $brand = Brand::where('code', '=', $code)->first();
        if(!$brand){
            self::setMsgCode(9003);
            self::sendJsonMsg();
        }
        $series = Sery::where('brand_id', $brand->id)->get();
        self::setData($series);
        self::sendJsonMsg();
    }

    public function getModels($code)
    {
        if(!$code) {
            self::setMsgCode(9001);
            self::sendJsonMsg();
        }
        $sery = Sery::where('code', '=', $code)->first();
        if(!$sery){
            self::setMsgCode(9003);
            self::sendJsonMsg();
        }
        $models = Motomodel::where('sery_id', $sery->id)->get();
        self::setData($models);
        self::sendJsonMsg();
    }

    public function capBrands() {
        $brandList = Brand::getActiveBrands();
        foreach ($brandList as &$item) {
            $firstChar = strtoupper(Utils::getStrFirstChar($item->name));
            DB::table('brands')
                ->where('code', $item->code)
                ->update(['firstchar' => $firstChar]);
        }
    }

    public function verifyId(Request $request) {
        if ($request->isMethod('post')) {
            $rules = [
                'real_name' => 'required|real_name',
                'id_no' => 'required|id_no',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                self::setMsgCode(1011);
            }
            // check if user already verified
            if(Auth::user()->profile->is_verified)
                self::setMsgCode(1012);
            $wechatUser = session('wechat.oauth_user');
            // check how many times does this user apply for sms
            if(User::getActionCount($wechatUser->id, 'id_card_verify') >= config('custom.ID_CARD_VERIFY_DAY_ALLOW') ) {
                self::setMsgCode(1008);
            }
            $data = $request->only('real_name', 'id_no');
            // check whether the id_no has already verified
            $userProfile = UserProfile::where('id_no', '=', $data['id_no'])
                ->where('is_verified', '=', 1)
                ->first();
            if($userProfile) {
                self::setMsgCode(1012);
            }
            Log::write('idcard', 'Verify user id no:' . http_build_query($request->all()));
            $rs = Utils::verifyIDCard($data['real_name'], $data['id_no']);
            // record action
            User::recordLimitAction($wechatUser->id, config('custom.limited_ops.id_card_verify'));
            if(!$rs->isok) {
                self::setMsgCode(1011);
            } else {
                $profile = Auth::user()->profile;
                $profile->update($data);
            }
            self::sendJsonMsg();
        }
    }

    public function upload(Request $request) {
        //
        $carImgDir = public_path().config('custom.car_img_path');
        if(!file_exists($carImgDir)) {
            Log::write('common', 'Create car image directory:'.$carImgDir);
            mkdir($carImgDir, 0755);
        }
        $files = $request->file('file');
        //var_dump($files);
        $data = [];
        foreach($files as $file) {
            if($file->isValid()) {
                if(!in_array($file->extension(), config('custom.car_img_valid_ext')))
                    continue;
                $path = $file->store('images/car_imgs');
                $fileName = basename($path);
                $fileArr = explode('.', $fileName);
                $fileName = $fileArr[0];
                $fileArr[0] = $fileName.'_thumb';
                $thumbFileName = implode(".", $fileArr); // thumbnail
                $fileArr[0] = $fileName.'_preview';
                $previewFileName = implode(".", $fileArr); // preview
                // deal with thumbnail
                $img = Image::make(public_path('uploads').'/'.$path)->resize(config('custom.car_img_width'), config('custom.car_img_height'));
                $img->save($carImgDir.'/'.$thumbFileName);
                // deal with preview image
                $img_preview = Image::make(public_path('uploads').'/'.$path);
                $imgHeight = (540*$img_preview->height())/$img_preview->width();
                $img_preview = $img_preview->resize(540, (int)$imgHeight);
                $img_preview->save($carImgDir.'/'.$previewFileName);
                $data[] = config('custom.car_img_path').'/'.$thumbFileName;
            }
        }
        if(count($data) > config('custom.car_img_max')) {
            self::setMsgCode(1015);
        }
        self::setData($data);
        self::sendJsonMsg();
    }
}

