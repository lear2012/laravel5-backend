<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class SiteController extends Controller
{
    //
    public function config() {
        $siteConfig = Redis::hgetall('site_config');
        return view('backend.site.config', [
            'siteConfig' => $siteConfig
        ]);
    }

    public function storeConfig(Request $request) {
        $mapImg = $request->get('map_img');
        if(!is_null($mapImg)) {
            Redis::hset('site_config', 'map_img', $mapImg);
        }
        return redirect()->back()->with('jsmsg', amaran_msg(trans('message.set_success'), 'success'));
    }

    public function test() {
        return view('backend.site.test', [

        ]);
    }
}
