<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class UserAgentMultiDeviceCheck extends Middleware
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
        $deviceKey = $request->header('user-agent');

        if(! $cachedDeviceKey = $redis->get(session('id') . ':deviceKey')){
            $redis->set(session('id') . ':deviceKey', $deviceKey);
        }

        if($deviceKey !== $cachedDeviceKey){
            $redis->set(session('id') . ':deviceKey', $deviceKey);

            if($redis->get(session('id') . ':multiDeviceClash')){
                Redis::del(session('id') . ':deviceKey');
                Redis::del(session('id') . ':multiDeviceClash');
                return redirect('/api/logout');
            }else{
                $redis->setex(session('id') . ':multiDeviceClash', 800, true);
            }
        }

        return $next($request);
    }
}
