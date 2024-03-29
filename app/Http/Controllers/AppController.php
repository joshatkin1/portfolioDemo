<?php

namespace App\Http\Controllers;

use App\Models\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AppController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('masterAuth')->only('appView');
        $this->middleware('auth:api')->except('appView');

        $randNum = random_int(1,6);
        if($randNum === 6){
            $this->middleware('userAgentCheck');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function appView(Request $req)
    {
        return view('app');
    }


//    public function fetchAllLocationOptions(){
//        return App::fetchAllLocationOptions();
//    }

//    public function fetchLocationOptionsByLetter(Request $request){
//
//        $loc_search = $request->letter;
//        $response = App::fetchLocationOptionsByLetter($loc_search);
//
//        return response($response, 200)
//            ->header('Content-Type', 'text/plain');
//    }
//
//    public function insertAppLocations(){
//        $result =  App::insertAppLocations();
//    }


}
