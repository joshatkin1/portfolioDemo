<?php

namespace App\Http\Controllers\Auth;

use App\Mail\VerificationCodeEmail;
use App\Models\AccountDeviceVerification;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::APP;

    protected $loginUser;
    public $MFArequired = true;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * OVERIDE BASE METHOD
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    final protected function attemptLogin($request)
    {

        $request->session()->flush();

        Cookie::queue('email', $request->input('email'), 12321311);

        $auth_success = $this->guard()->attempt($this->credentials($request), $request->filled('remember'));

        if ($auth_success){
            //GET USER DETAILS
            $user = User::where('email', '=', $request->input('email'))->first();

            $this->loginUser = $user;
            $this->MFArequired = true;

            //GET USER DEVICE ID HASH CHECK IF DEVICE IS VERIFIED AND REDIRECT TO MFA IF (IP + HTTP_USER_AGENT hashed)
            if(Cookie::has('deviceVerificationKey')){
                $device_verf_cookie = Cookie::get('deviceVerificationKey');
                $redis = Redis::connection();
                $redis->set($this->loginUser->id . ':deviceVerificationKey', $device_verf_cookie);
                $this->loginUser->deviceCookie = $device_verf_cookie;
            }else{
                $device_verf_cookie = '-1';
            }

            $user_device = $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $device_verf_cookie;

            //VERIFY CURRENT USER DEVICE IS LINKED TO ACCOUNT AND AUTHORIZED
            if($user->verified_device_keys){
                foreach($user->verified_device_keys as $deviceHash){
                    if (Hash::check($user_device , $deviceHash)) {
                        //IF DEVICE IS ALREADY AUTHENTICATED SET MULTI FACTOR NOT REQUIRED
                        session(['device_auth' => true]);
                        $this->MFArequired = false;
                        break;
                    }
                }
            }

            return true;
        }

        return false;
    }

    /**
     * OVERIDING BASE METHOD
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    final protected function sendLoginResponse($request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        //SET SESSION DATA
        session([
            'loggedIn' => true,
            'id' => $this->loginUser->id,
            'name' => $this->loginUser->name,
            'email' => $this->loginUser->email,
            'deviceKey' => $this->loginUser->deviceCookie,
        ]);

        if($this->MFArequired === false){
            session(['device_auth' => true]);
            return redirect('/app');
        }else if($this->MFArequired === true){
            session(['device_auth' => false]);
            $accountVerification = new AccountDeviceVerification();
            $code = $accountVerification->formatVerificationCode();
            Mail::to(session('email'))->send(new VerificationCodeEmail($code));
            return redirect('/verify-device');
        }
    }
}
