<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\SectionSelfRegRequest;
use App\Http\Requests\Frontend\CameraRegRequest;
use ChannelLog as Log;
use App\Models\SectionEnrollment;
use DB;
use App\Helpers\Utils;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as JavaScript;
use EasyWeChat;
use EasyWeChat\Foundation\Application;

class XinjiangController extends Controller
{
    //
    public function __construct(Application $wechat)
    {
        parent::__construct($wechat);
    }

    public function index() {
        return view('frontend.xinjiang.index', [

        ]);
    }

    public function saveSectionSelfReg(SectionSelfRegRequest $request) {
        $data = $request->all();
        $enrollment = new SectionEnrollment();
        $data['reg_type'] = 1;
        $enrollment->fill($data);
        if(!$enrollment->save()) {
            self::setMsgCode(1017);
        }
        self::setMsg('报名成功，稍后我们会与您联系！');
        self::sendJsonMsg();
    }

    public function saveCameraReg(CameraRegRequest $request) {
        $data = $request->all();
        $enrollment = new SectionEnrollment();
        $data['reg_type'] = 2;
        $enrollment->fill($data);
        if(!$enrollment->save()) {
            self::setMsgCode(1017);
        }
        self::setMsg('感谢您的支持，稍后我们会与您联系！');
        self::sendJsonMsg();
    }
}
