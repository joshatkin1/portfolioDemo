<?php

namespace App\Http\Controllers;

use App\Models\Company as Company;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('userDeviceAuth');
    }

    /**
     * FETCH ALL USERS SESSION DATA
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function fetchAllSessionData(){

        if(Session::has('id')){

            $session_data = json_encode( Session::all() , true);

            return response($session_data, 200)
                ->header('Content-Type', 'application/json');
        }

        return response("not logged in", 401)
            ->header('Content-Type', 'text/plain');
    }

    public function fetchUserSessionCompanyLinkName(){
        if(Session::has('company_link')){
            if(session('company_link') !== null){
                $company = Company::where('company_id' , session('company_link'))->first();
                $company_name = $company->company_name;
                if($company_name){
                    session(["company_name" => $company_name]);
                }
                return response($company_name, 200)
                    ->header('Content-Type', 'text/plain');
            }
        }
        return response("", 500)
            ->header('Content-Type', 'text/plain');
    }
}
