<?php

namespace App\Http\Controllers\Auth;

use App\Mail\VerificationCodeEmail;
use App\Models\AccountDeviceVerification;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

    protected $user;
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
    final protected function attemptLogin(Request $request)
    {

        $request->session()->flush();

        Cookie::queue('email', $request->input('email'), 12321311);

        $request["password"] = $request["password"] . 'H4uhsh7!2Gv3d';

        if (Auth::attempt($this->credentials($request))){

            $user = Auth::user();

            $this->user = $user;

            $this->MFArequired = true;

            $device_verf_cookie =  $request->cookie('deviceVerificationKey');


            //GET USER DEVICE ID HASH CHECK IF DEVICE IS VERIFIED AND REDIRECT TO MFA IF (IP + HTTP_USER_AGENT hashed)
            if($device_verf_cookie && $device_verf_cookie !== "" && $device_verf_cookie !== null){

                $redis = Redis::connection();
                $redis->set($this->user->id . ':deviceVerificationKey', $device_verf_cookie);
                $this->user->deviceCookie = $device_verf_cookie;

                $user_device = $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $device_verf_cookie;

                //VERIFY CURRENT USER DEVICE IS LINKED TO ACCOUNT AND AUTHORIZED
                if($this->user->verified_device_keys){
                    foreach($this->user->verified_device_keys as $deviceHash){
                        if (Hash::check($user_device , $deviceHash)) {
                            //IF DEVICE IS ALREADY AUTHENTICATED SET MULTI FACTOR NOT REQUIRED
                            session(['device_auth' => true]);
                            $this->MFArequired = false;
                            break;
                        }
                    }
                }

            }

            return true;
        }

        return back()->withInput();
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

        if(! Auth::user()){
            return back()->withInput();
        }

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        //SET SESSION DATA
        session([
            'loggedIn' => true,
            'id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'job_title' => $this->user->job_title,
            'company_link' => $this->user->company_link,
            'deviceKey' => $this->user->deviceCookie,
        ]);

        if($this->MFArequired === false){

            session(['device_auth' => true]);

            $preferredDestinationPage =  $request->cookie('preferredDestinationPage');

            if($preferredDestinationPage && isset($preferredDestinationPage) && $preferredDestinationPage !== null){
                return redirect($preferredDestinationPage);
            }else{
                return redirect('/app');
            }

        }else if($this->MFArequired === true){
            session(['device_auth' => false]);
            $accountVerification = new AccountDeviceVerification();
            $code = $accountVerification->formatVerificationCode();

            Mail::to(session('email'))->send(new VerificationCodeEmail($code));

            return redirect('/verify-device');
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout (Request $request) {
        //logout user
        try{
            auth()->logout();
            $request->session()->flush();
            Redis::del(session('id') . ':deviceVerificationKey');
            Redis::del(session('id') . ':multiDeviceClash');
        }catch(\Exception $e){}
        // redirect to homepage
        $cookie = Cookie::forget('jwt');
        return redirect('/')->withCookie($cookie);
    }
}
