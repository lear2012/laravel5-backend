<?php

namespace App\Http\Middleware;

use Closure;
use ChannelLog as Log;

class RequestResponseLogger
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
        return $next($request);
    }

    public function terminate($request, $response)
    {
        if($request->ajax()) {
            Log::write('common', 'Request info:', [
                'url' => $request->fullUrl(),
                'params' => $request->all(),
                'response' => $response
            ]);
        } else {
            Log::write('common', 'Request info:', [
                'url' => $request->fullUrl(),
                'params' => $request->all(),
            ]);
        }
    }
}
