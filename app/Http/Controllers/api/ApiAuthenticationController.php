<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
        $this->middleware('guest')->except('logout');
    }

    /**
     * OVERIDE BASE METHOD
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    final protected function login(Request $request)
    {

        $request["password"] = $request["password"] . 'H4uhsh7!2Gv3d';

        if (Auth::attempt($this->credentials($request))){

            $user = Auth::user();
            $userModel = User::find($user->id);
            $token = $userModel->createToken('accessToken')->accessToken;

            return response($token, 200);
        }

        return false;//FAILED LOGIN
    }
}
