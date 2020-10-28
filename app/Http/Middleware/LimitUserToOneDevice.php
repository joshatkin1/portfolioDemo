<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class LimitUserToOneDevice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $redis = Redis::connection();
        $userDeviceKey = $request->cookie('deviceVerificationKey');
        $cachedDeviceKey = $redis->get(session('id') . ':deviceVerificationKey');

        if($userDeviceKey === $cachedDeviceKey){
            return $next($request);
        }

        if($redis->get(session('id') . ':multiDeviceClash')){

            Redis::del(session('id') . ':deviceVerificationKey');
            Redis::del(session('id') . ':multiDeviceClash');
            session()->flush();
            return redirect('/login?multi-user-clash=true');
        }

        $redis->setex(session('id') . ':multiDeviceClash', 400, true);
        $redis->set(session('id') . ':deviceVerificationKey', $userDeviceKey);

        return $next($request);
    }
}
