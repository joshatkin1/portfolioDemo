<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class LimitUserToOneDevice  extends Middleware
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
        $deviceKey = $request->cookie('deviceVerificationKey');

        if(! $cachedDeviceKey = $redis->get(session('id') . ':deviceVerificationKey')){
            $redis->set(session('id') . ':deviceVerificationKey', $deviceKey);
        }

        if($deviceKey !== $cachedDeviceKey){
            $redis->set(session('id') . ':deviceVerificationKey', $deviceKey);

            if($redis->get(session('id') . ':multiDeviceClash')){
                Redis::del(session('id') . ':deviceVerificationKey');
                Redis::del(session('id') . ':multiDeviceClash');
                return redirect('/api/logout');
            }else{
                $redis->setex(session('id') . ':multiDeviceClash', 400, true);
            }
        }

        return $next($request);
    }
}
