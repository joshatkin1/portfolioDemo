<?php

namespace App\Http\Controllers;

use App\Mail\VerificationCodeEmail;
use App\Models\AccountDeviceVerification;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class DeviceVerificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable|\Illuminate\Http\RedirectResponse
     */
    final public function index(Request $request)
    {
        if(session('device_auth')){
            if(session('device_auth') === true){
                return redirect(RouteServiceProvider::APP);
            }
        }

        $email = Session::get('email');
        return view('device-verification', ['email' => $email]);
    }

    /**
     * RESEND ACCOUNT DEVICE VERIFICATION CODE
     * @param AccountDeviceVerification $accountVerification
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    final public function resendDeviceVerificationCode(AccountDeviceVerification $accountVerification){
        $email = Session::get('email');
        if($accountVerification->limitVerificationCodes()){
            $code = $accountVerification->formatVerificationCode();
            Mail::to($email)->send(new VerificationCodeEmail($code));
            return view('device-verification', ['email' => $email]);
        }

        return view('device-verification', ['email' => $email, 'error' => '']);
    }

    /**
     * SUBMIT DEVICE VERIFICATION CODE
     * @param Request $request
     * @param AccountDeviceVerification $accountDeviceVerification
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    final public function submitDeviceVerificationCode(Request $request, AccountDeviceVerification $accountDeviceVerification){

        $validator = Validator::make($request->input(), [
            'verification-code' => ["required", "string", "max:20"],
        ]);

        if ($validator->fails()) {
            return response()
                ->view('device-verification', ['email' => session('email')], 422)
                ->header('Content-Type', 'html');
        }

        $c = $request->input('verification-code');
        $c = str_replace(" ","",$c);

        $codes = $accountDeviceVerification->fetchAccountVerificationCodes();

        foreach ($codes as $code){

            if($code->code === $c){
                $deviceCookie = $accountDeviceVerification->addThisDeviceToVerifiedList();
                session(['device_auth' => true]);

                Cookie::queue(
                    'deviceVerificationKey',
                    $deviceCookie,
                    9999999999
                );

                return Redirect::route('app');
            }
        }

        if (! $request->expectsJson()) {
            $email = Session::get('email');
            return Redirect::route('device-verification',  ['email' => $email, 'error' => 'verification code is incorrect or expired']);
        }else{
            return Response('',401,[
                'Content-type' => 'application/json',
            ]);
        }
    }
}
