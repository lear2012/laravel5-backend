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
