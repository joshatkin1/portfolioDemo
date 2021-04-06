<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('masterAuth')->only('profileView');
        $this->middleware('auth:api')->except('profileView');

        $randNum = random_int(1,10);
        if($randNum === 6){
            $this->middleware('userAgentCheck');
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    final public function profileView(){
        return view('profile');
    }
}
