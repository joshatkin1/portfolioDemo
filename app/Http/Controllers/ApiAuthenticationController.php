<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeEmail;
use App\Models\AccountDeviceVerification;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;


class ApiAuthenticationController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::APP;

    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except('login');
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:8',
        ]);
        if(!$validated){return redirect()->back();}

        $request["password"] = $request["password"] . 'H4uhsh7!2Gv3d';
        $credentials = $this->credentials($request);
        if (! $token = auth()->attempt($credentials)) {
            return redirect()->back()->withErrors("password" , "invalid credentials");
        }

        $request->session()->regenerate();
        $user = auth()->user();

        Session::put([
            'loggedIn' => true,
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'job_title' => $user->job_title,
            'company_link' => $user->company_link,
            'device_auth' => false,
        ]);

        $redis = Redis::connection();
        $redis->set(Session::get('id') . ':deviceAgent', $request->header('user-agent'));

        $device_verf_cookie =  $request->cookie('deviceVerificationKey');
        //GET USER DEVICE ID HASH CHECK IF DEVICE IS VERIFIED AND REDIRECT TO MFA IF (IP + HTTP_USER_AGENT hashed)
        if($device_verf_cookie && $device_verf_cookie !== "" && $device_verf_cookie !== null){

            $user->deviceCookie = $device_verf_cookie;

            $user_device = $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $device_verf_cookie;

            //VERIFY CURRENT USER DEVICE IS LINKED TO ACCOUNT AND AUTHORIZED
            if($user->verified_device_keys){
                foreach($user->verified_device_keys as $deviceHash){
                    if (Hash::check($user_device , $deviceHash)) {
                        //IF DEVICE IS ALREADY AUTHENTICATED SET MULTI FACTOR NOT REQUIRED
                        Session::put(['device_auth' => true]);
                        break;
                    }
                }
            }
        }

        $emailcookie = cookie('email', $request->input('email'), 12321311, '/', '', true, false );
        $cookie = cookie('jwt', $token, 7200, '/', '', true, true );

        if(!Session::get("device_auth")){
            $accountVerification = new AccountDeviceVerification();
            $code = $accountVerification->formatVerificationCode();
            Mail::to(Session::get('email'))->send(new VerificationCodeEmail($code));
            return redirect('api/verify-device')->withCookies([$emailcookie, $cookie]);
        }

        return redirect('/profile')->withCookies([$emailcookie, $cookie]);
    }


    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->flush();
        return redirect('/login', 302)->withCookies([Cookie::forget('jwt'),Cookie::forget('workcloud_session')]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
