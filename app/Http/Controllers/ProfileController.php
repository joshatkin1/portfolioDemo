<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('masterAuth')->only('profileView');

        //VERIFY USER DEVICE IS EXPECTED CURRENT DEVICE
        $num = random_int(1,14);
        if($num === 6){
            $this->middleware('multiUserCheck');
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    final public function profileView(){
        return view('profile');
    }
}
