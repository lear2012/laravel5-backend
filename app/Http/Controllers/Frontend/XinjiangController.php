<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\SectionSelfRegRequest;
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
}
