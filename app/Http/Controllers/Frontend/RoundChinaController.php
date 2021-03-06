<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\SelfRegRequest;
use App\Http\Requests\Frontend\LiftRegRequest;
use App\Http\Requests\Frontend\ClubRegRequest;
use App\Http\Requests\Frontend\ApplyChetieRequest;
use App\Models\ChetieApply;
use App\Models\KeyeClub;
use App\Models\KeyeEnrollment;
use App\Models\KeyeLift;
use App\Models\TopicImage;
use Illuminate\Http\Request;
use ChannelLog as Log;
use App\Models\KeyeRoute;
use Illuminate\Support\Facades\Redis;
use DB;
use App\Helpers\Utils;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as JavaScript;
use EasyWeChat;
use EasyWeChat\Foundation\Application;

class RoundChinaController extends Controller
{
    public function __construct(Application $wechat)
    {
        parent::__construct($wechat);
    }

    public function index() {
        $c1 = KeyeEnrollment::all()->count();
        $c2 = KeyeLift::all()->count();
        $c3 = KeyeClub::all()->count();
        $allCount = $c1+$c2+$c3;
        $thumbupCount = KeyeRoute::getThumbupCount();
        $swiperImages = TopicImage::getActiveImageList();
        $westLines = KeyeRoute::getActiveRouteList();
        $eastLines = KeyeRoute::getInactiveRouteList();
        $siteConfig = Redis::hgetall('site_config');
        return view('frontend.roundchina.index', [
            'westLines' => $westLines,
            'eastLines' => $eastLines,
            'allCount' => $allCount,
            'thumbupCount' => $thumbupCount,
            'js' => $this->js,
            'siteConfig' => $siteConfig,
            'swiperImages' => $swiperImages,
        ]);
    }

    public function selfDrivingReg() {
        $points = Utils::getFirstHalfPoints();
        return view('frontend.roundchina.selfreg', [
            'points' => $points
        ]);
    }

    public function selfRegList() {
        $items = KeyeEnrollment::getSelfRegCars();
        JavaScript::put([
            'firstPageCars' => $items,
        ]);
        return view('frontend.roundchina.selfreg_list', [
            'items' => $items
        ]);
    }

    public function liftReg() {
        $expiredTimestamp = 1509965247;
        $items = KeyeEnrollment::getLiftingCars();
        JavaScript::put([
            'firstPageCars' => $items,
        ]);
        return view('frontend.roundchina.liftreg', [
            'items' => $items,
            'expiredTimestamp' => $expiredTimestamp
        ]);
    }

    public function clubReg() {
        return view('frontend.roundchina.clubreg');
    }

    public function saveSelfReg(SelfRegRequest $request) {
        $data = $request->all();
        if(!isset($data['agree']) || $data['agree'] != 1) {
            self::setMsgCode(1019);
        }
        if(!isset($data['lift']) || $data['lift'] != 1) {
            $data['available_seats'] = 0;
        }
        $enrollment = new KeyeEnrollment();
        $enrollment->fill($data);
        if(!$enrollment->save()) {
            self::setMsgCode(1017);
        }
        self::setMsg('报名成功，稍后我们会与您联系！');
        self::sendJsonMsg();
    }

    public function saveLiftReg(LiftRegRequest $request) {
        $data = $request->all();
        if(!isset($data['agree']) || $data['agree'] != 1) {
            self::setMsgCode(1019);
        }
        $enrollment = KeyeEnrollment::find($data['enrollment_id']);
        if(!$enrollment) {
            self::setMsgCode(9003);
        }
        if((int)$enrollment->seats_taken >= (int)$enrollment->available_seats) {
            self::setMsgCode(1021);
        }
        $lift = new KeyeLift();
        $lift->fill($data);
        if(!$lift->save()) {
            self::setMsgCode(1017);
        }
        // update enrollment seats taken
        $enrollment->seats_taken = (int)$enrollment->seats_taken + 1;
        $enrollment->save();
        self::setMsg('报名成功，稍后我们会与您联系！');
        self::sendJsonMsg();
    }

    public function saveClubReg(ClubRegRequest $request) {
        $data = $request->all();
        if(!isset($data['agree']) || $data['agree'] != 1) {
            self::setMsgCode(1019);
        }
        unset($data['agree']);
        $club = new KeyeClub();
        $club->fill($data);
        if(!$club->save()) {
            self::setMsgCode(1017);
        }
        self::setMsg('报名成功，稍后我们会与您联系！');
        self::sendJsonMsg();
    }

    // 点赞
    public function thumbUp($id=null) {
        // 总支持数
        //$c = KeyeRoute::getThumbupCount();
        // 防止ip刷
        $ip = \Request::ip();
        Redis::incr('ip:'.$ip.':thumbup');
        if(Redis::get('ip:'.$ip.':thumbup') > 100) {
            self::setMsgCode(1020);
        }
        if(is_null($id) || empty($id)) {
            Redis::incr('all_thumbup');
            self::sendJsonMsg();
        }
        if(!is_numeric($id)) {
            self::setMsgCode(9001);
        }
        $route = KeyeRoute::find($id);
        if(!$route) {
            self::setMsgCode(9003);
        }
        Redis::incr('route:'.$id.':thumbup');
        self::sendJsonMsg();
    }

    public function getAvailableCars(Request $request) {
        $params = [];
        $params['keyword'] = $request->get('keyword');
        $items = KeyeEnrollment::getLiftingCars($params);
        self::setData($items);
        self::sendJsonMsg();
    }

    public function getMoreSelfRegCars(Request $request) {
        $items = KeyeEnrollment::getSelfRegCars();
        self::setData($items);
        self::sendJsonMsg();
    }

    public function applyChetie() {
        $points = Utils::getFirstHalfPoints();
        return view('frontend.roundchina.apply_chetie', [
            'points' => $points
        ]);
    }

    public function saveApplyChetie(ApplyChetieRequest $request) {
        $data = $request->all();
        $item = new ChetieApply();
        $item->fill($data);
        $item->status = 0;
        if(!$item->save()) {
            self::setMsgCode(1022);
        }
        self::setMsg('我们已经收到您的申请，稍后我们会根据您提供的信息发送车贴！');
        self::sendJsonMsg();
    }

}
