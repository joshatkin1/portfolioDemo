<?php

namespace App\Http\Controllers;

use App\Models\App;

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

//        //VERIFY USER DEVICE IS EXPECTED CURRENT DEVICE
//        $num = random_int(1,2);
//        if($num === 2){
//            $this->middleware('multiUserCheck');
//        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function appView()
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
