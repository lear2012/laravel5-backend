<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\EnrollmentRequest;
use App\Models\KeyeEnrollment;
use Illuminate\Http\Request;
use ChannelLog as Log;
use App\Models\KeyeRoute;
use Illuminate\Support\Facades\Redis;

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

    public function enroll(EnrollmentRequest $request) {
        $enrollment = new KeyeEnrollment();
        $data = $request->all();
        $enrollment->fill($data);
        if($enrollment->save()) {
            self::sendJsonMsg();
        } else
            self::setMsgCode(1017);
    }
}
