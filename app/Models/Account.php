<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Account extends Model
{

    protected $table = 'companies';
    protected $primaryKey = 'id';

    protected $fillable = [
        'connection_tokens','app_subscriptions' , 'app_settings', 'subscription_cost', 'recruitment_details'
    ];

    public static function updateCompanyAccountSubs($sub){
        $company_link = session('company_link');
        $company_subs = self::getCompanySubs();
        $new_company_subs = array();

        $key = array_search($sub, $company_subs);

        if($key > -1){
            foreach($company_subs as $s){
                if($s !== $sub){
                    array_push($new_company_subs, $s);
                }
            }
        }else{
            array_push($company_subs, $sub);
            $new_company_subs = $company_subs;
        }

        $company_subs = $new_company_subs;
        $new_company_subs = json_encode($new_company_subs);

        DB::table('companies')
            ->where('id', $company_link)
            ->update(['app_subscriptions'  => $new_company_subs]);

        return  $company_subs;
    }

    protected static function getCompanySubs(){

        $company_link = session('company_link');

        $result = DB::table('companies')
            ->select('app_subscriptions')
            ->where('id' , '=' , $company_link)
            ->get();

        $result = json_decode($result[0]->app_subscriptions);

        return $result;
    }

    protected static function subscriptionCost(){
        $company_link = session('company_link');

        $result = DB::table('companies')
            ->select('subscription_cost')
            ->where('id' , '=' , $company_link)
            ->get();

        $result = json_decode($result[0]->subscription_cost);

        return $result;
    }

    protected static function increaseSubscriptionCost(){
        if(session('job_level') < 4){return false;}//MASTER ADMIN AUTH FAILED
        $company_link = session('company_link');

        DB::table('companies')
            ->where('id' , $company_link)
            ->increment('subscription_cost', 7);

        return true;
    }

    protected static function decreaseSubscriptionCost(){
        if(session('job_level') < 4){return false;}//MASTER ADMIN AUTH FAILED
        $company_link = session('company_link');

        DB::table('companies')
            ->where('id' , $company_link)
            ->decrement('subscription_cost', 7);

        return true;
    }
}
