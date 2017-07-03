<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\EnrollmentRequest;
use App\Http\Requests\Frontend\LiftCreateRequest;
use App\Models\KeyeEnrollment;
use App\Models\KeyeLift;
use Illuminate\Http\Request;
use ChannelLog as Log;
use App\Models\KeyeRoute;
use Illuminate\Support\Facades\Redis;
use DB;

class RoundChinaController extends Controller
{
    // 点赞
    public function thumbUp($id=null) {
        // 总支持数
        //$c = KeyeRoute::getThumbupCount();
        // 防止ip刷
        $ip = \Request::ip();
        Redis::incr('ip:'.$ip.':thumbup');
        if(Redis::get('ip:'.$ip.':thumbup') > 100) {
            self::sendJsonMsg();
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

    /*
     * 自驾报名
     * */
    public function enroll(EnrollmentRequest $request) {
        $enrollment = new KeyeEnrollment();
        $data = $request->all();
        $enrollment->fill($data);
        if($enrollment->save()) {
            self::sendJsonMsg();
        } else
            self::setMsgCode(1017);
    }

    /*
     * 搭车
     * */
    public function liftMe(LiftCreateRequest $request) {
        $id = $request->get('eid');
        if(!is_numeric($id)) {
            self::setMsgCode(9001);
        }
        $item = KeyeEnrollment::find($id);
        if(!$item) {
            self::setMsgCode(9003);
        }
        $lift = new KeyeLift();
        $lift->fill($request->all());
        $lift->enrollment_id = $id;
        if($lift->save()) {
            self::sendJsonMsg();
        } else
            self::setMsgCode(1018);
    }

    public function getAvailableCars() {
        $items = KeyeEnrollment::getLiftingCars();
        self::setData($items);
        self::sendJsonMsg();
    }

}
