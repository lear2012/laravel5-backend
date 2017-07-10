<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Redis;
use DB;

class KeyeRoute extends Model
{
    //
    use SoftDeletes;

    protected $dateFormat = 'U';

    protected $fillable = [
        'title',
        'start',
        'end',
        'cover_img',
        'url',
        'ord',
        'votes',
        'is_front',
        'active'
    ];

    public static function getActiveRouteList() {
        return KeyeRoute::where('active', '=', 1)
            ->where('is_front', '=', 1)
            ->whereNull('deleted_at')
            ->orderBy('ord', 'asc')
            ->get();
    }

    public static function getInactiveRouteList() {
        return KeyeRoute::where('active', '=', 0)
            ->where('is_front', '=', 1)
            ->whereNull('deleted_at')
            ->orderBy('ord', 'asc')
            ->get();
    }

    public static function getThumbupCount() {
        $all = Redis::get('all_thumbup');
        if(is_null($all))
            $all = 0;
        $all = (int)$all;
        $routes = DB::table('keye_routes')
            ->where('is_front', '=', 1)
            ->where('active', '=', 1)
            ->select('id')
            ->get();
        foreach($routes as $route) {
            $tmp = Redis::get('route:'.$route->id.':thumbup');
            $all += !is_null($tmp) ? (int)$tmp : 0;
        }
        return $all;
    }
}
