<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeEmail;
//use App\Mail\WelcomeEmail;
use App\Models\AccountDeviceVerification;
use App\Providers\RouteServiceProvider;
use App\Models\User as User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::APP;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255','min:2'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'job_title' => ['required','string', 'max:255'],
            'password' => ['required', 'string', 'min:10',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/\\d/', $value)) {
                        $fail($attribute. 'does not pass our requirements.');
                    }
                    if(!preg_match('/[A-Z]/', $value)){
                        $fail($attribute. 'does not pass our requirements.');
                    }
                    if(!preg_match('/[a-z]/', $value)){
                        $fail($attribute. 'does not pass our requirements.');
                    }
                },
            ],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    final protected function create(array $data)
    {
        $deviceKeys = [];
        $password = Hash::make($data['password'] . 'H4uhsh7!2Gv3d');
        $name = ucwords(strtolower($data['name']));
        $job_title = ucwords(strtolower($data['job_title']));
        $email = $data["email"];

        $user = User::create([
            'name' => $name,
            'job_title' => $job_title,
            'email' => $email,
            'user_tel' => "",
            'company_link' => NULL,
            'logged_in' => 1,
            'failed_logins' => 0,
            'last_password_change' => time(),
            'joined_date' => time(),
            'password' =>  $password,
        ]);

        session([
            'loggedIn' => true,
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'job_title' => $user->job_title,
        ]);

        //Mail::to($user->email)->send(new WelcomeEmail($user->name, $user->email));

        Cookie::queue('preferredDestinationPage', '/app', 12321311);

        $accountVerification = new AccountDeviceVerification();
        $code = $accountVerification->formatVerificationCode();
        Mail::to($user->email)->send(new VerificationCodeEmail($code));

        return $user;
    }
}
