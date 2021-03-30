<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends AppController
{
    //

    public function __construct()
    {
        parent::__construct();
    }

    final public function getUserAccountDetails(){
        return Account::find(session('id'));
    }

    final public function fetchAppSettings(Company $company){

        $settings = $company->fetchAppSettings();

        return response($settings, 200)
            ->header('Content-Type', 'text/plain');
    }

    final public function updateAppSettings(Request $request, Company $company){
        if(session('job_level') < 3){return false;}//MASTER ADMIN AUTH FAILED

        $settingName = $request->settingName;
        $settingValue = $request->settingValue;

        $response = $company->updateAppSettings($settingName, $settingValue);

        return response($response, 200)
            ->header('Content-Type', 'text/plain');
    }

    final public function updateCompanyAccountSubs(Request $request){
        if(session('job_level') < 4){return false;}//MASTER ADMIN AUTH FAILED
        $sub = $request->subscription;
        $response = \App\Account::updateCompanyAccountSubs($sub);
        return response($response, 200)
            ->header('Content-Type', 'text/plain');
    }

    final public function getCompanySubs(){
        $response = Account::getCompanySubs();
        return response($response, 200)
            ->header('Content-Type', 'text/plain');
    }

    final public function subscriptionCost(){
        if(session('job_level') < 4){return false;}//MASTER ADMIN AUTH FAILED
        $response = Account::subscriptionCost();
        return response($response, 200)
            ->header('Content-Type', 'text/plain');
    }

    final public function fetchCompanyRecruitmentConnectionTokens(Company $company){
        $companyCache = $company->getCompanyCacheObject();
        $response = $companyCache["connection_tokens"];
        return response($response, 200)
            ->header('Content-Type', 'text/plain');
    }

    final public function fetchCompanyRecruitmentJobAdvertCount(){
        $jobAdvertCount = DB::table('job_adverts')
            ->where('company_link' , '=', session('company_link'))
            ->where('advert_open' , '=', 1)
            ->count();

        return response($jobAdvertCount, 200)
            ->header('Content-Type', 'text/plain');
    }



}
