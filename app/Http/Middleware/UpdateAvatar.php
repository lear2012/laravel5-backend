<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class UpdateAvatar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $wechatUser = session('wechat.oauth_user'); // 拿到授权用户资料
        if(isset($wechatUser)) {
            DB::table('user_profiles')
                ->where('wechat_id', $wechatUser->id)
                ->update(['avatar' => $wechatUser->avatar]);
        }
        return $next($request);
    }
}
