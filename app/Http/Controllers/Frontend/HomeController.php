<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use DB;
use App\Models\UserProfile;
use App\Helpers\Utils;
use ChannelLog as Log;

/**
 * Class HomeController
 * @package App\Http\Controllers\Frontend
 */
class HomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {

    }


    /**
     *
     */
    function index()
    {
        return view('frontend.home');
    }

    function memberList() {
        return view('frontend.member_list', [
            'expDrivers' => User::getExpdrivers(),
            'paidMembers' => User::getPaidMembers()
        ]);
    }

    function memberRegister(Request $request) {
        echo urlencode('http://keye.liaollisonest.com/wechat?target=wechat/register');
        exit;
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
        return view('frontend.register');
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

}
