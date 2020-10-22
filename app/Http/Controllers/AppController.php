<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;

class AppController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('userDeviceAuth');

        //VERIFY USER DEVICE IS EXPECTED CURRENT DEVICE
        $num = random_int(1,14);
        if($num === 6){
            $this->middleware('multiUserCheck');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('app');
    }


}
