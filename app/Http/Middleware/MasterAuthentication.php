<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MasterAuthentication
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

        if(!Session::has('loggedIn')){
            return redirect(RouteServiceProvider::HOME);
        }
        if(Session::get('loggedIn')  !== true){
            return redirect(RouteServiceProvider::HOME);
        }
        if(Session::get('device_auth') !== true){
            return redirect('/api/verify-device');
        }

        return $next($request);
    }
}
