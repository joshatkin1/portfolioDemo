<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\CloudSubscription;
use App\Models\CloudSetting;
use App\Models\User;


class Company extends Model
{

    protected $table = 'companies';
    protected $primaryKey = 'company_id';
    public static $staticMakeHidden;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name',
        'company_industry',
        'employee_count',
        'company_number',
        'master_admin',
        'company_email',
        'company_tel',
        'subscription_cost',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'subscription_cost',
    ];

    public function __construct()
    {
        parent::__construct();

        if(session('company_link')){
            $this->company_id = session('company_link');
        }

        if (isset(self::$staticMakeHidden)){
            $this->makeHidden(self::$staticMakeHidden);
        }
    }

    public function __destruct()
    {
        self::$staticMakeHidden = null;
    }

    final public function users(){
        $this->belongsToMany('App\Models\User','users', 'company_link');
    }

    final public function subscriptions(){
        return $this->hasMany('App\Models\CloudSubscription','company_id', 'company_id');
    }

    final public function cloudsettings(){
        return $this->hasOne('App\Models\CloudSetting','company_id', 'company_id');
    }

    /**
     * Get the job adverts for the blog post.
     */
    public function jobAdverts()
    {
        return $this->hasMany('App\JobAdvert', 'id','company_link');
    }

    final public function createCompanyCacheObject(){
        $company_id = session('company_link');
        $cache_key = $this->getCompanyCacheKey();

        $company = DB::table('companies')
            ->where('id', '=' , $company_id)
            ->first();

        $company = json_encode($company);


        try {
            cache([$cache_key => $company], now()->addMinutes(480));
        } catch (\Exception $e) {
            Cache::add($cache_key,$company);
        }

        return $company;
    }

    final public function forgetCompanyCache(){
        $cacheKey = $this->getCompanyCacheKey();
        if(Cache::has($cacheKey)){
            Cache::forget($cacheKey);
        }
        return true;
    }

    final protected static function fetchRecruitmentData(){
        $company_link = session('company_link');

        $result = DB::table('companies')
            ->select('recruitment_details')
            ->where('id' , '=' , $company_link)
            ->get();

        return $result[0]->recruitment_details;
    }

    final public function fetchAppSettings(){
        $companyCache = $this->getCompanyCacheObject();
        $settings = json_decode($companyCache["app_settings"], true);
        return $settings;
    }

    final public function updateAppSettings($settingName, $settingValue){

        $settings = $this->fetchAppSettings();
        $this->forgetCompanyCache();

        $settings[$settingName] = $settingValue;

        json_encode($settings);

        $result = DB::table('companies')
            ->where('id', $this->company_id)
            ->update(['app_settings'  => $settings]);

        return $result;
    }

    final protected function getCompanyCacheKey(){
        $cache_key = 'company_' . session('company_link') . '_cache_object';
        return $cache_key;
    }

    final public function getCompanyCacheObject(){
        $cache_key = $this->getCompanyCacheKey();

        if(Cache::missing($cache_key)){
            $company_object = $this->createCompanyCacheObject();
        }else{
            $company_object = Cache::get($cache_key);
        }

        return json_decode($company_object, true);
    }

    final protected static function createNewDepartment($department_name){
        $table = session('database_prefix') . 'departments';
        $department_name = ucwords(strtolower($department_name));
        $dep_alerts = json_encode([]);
        $dep_feed = json_encode([]);

        $dep_id = DB::table($table)->insertGetId(
            [
                'department_name' => $department_name,
                'department_privacy' => 0,
                'department_alerts' => $dep_alerts,
                'news_feed' => $dep_feed
            ]
        );

        $result = DB::table($table)
            ->where('id', '=' , $dep_id)
            ->first();

        return json_encode($result);
    }

    final protected static function deleteCompanyDepartment($department_id){
        $table = session('database_prefix') . 'departments';

        $old_name =  $result = DB::table($table)
            ->where('id' , '=' , $department_id)
            ->value('department_name');

        $result = DB::table($table)
            ->where('id', "=" , $department_id)
            ->delete();

        return $old_name;
    }

    final protected static function departmentList(){

        $table = session('database_prefix') . 'departments';

        $result = DB::table($table)
            ->get();

        return $result;
    }

    final protected static function toggleDepartmentPrivacySetting($department_id){
        $table = session('database_prefix') . 'departments';

        $new_privacy =  $result = DB::table($table)
            ->where('id' , '=' , $department_id)
            ->value('department_privacy');

        $new_privacy = !$new_privacy;

        $result = DB::table($table)
            ->where('id' , '=' , $department_id)
            ->update([
                'department_privacy' => $new_privacy
            ]);

        return $result;
    }

    final protected static function changeCompanyDepartmentName($department_id, $department_name){
        $table = session('database_prefix') . 'departments';

        $old_name = DB::table($table)
            ->where('id' , '=' , $department_id)
            ->value('department_name');

        $result = DB::table($table)
            ->where('id' , '=' , $department_id)
            ->update([
                'department_name' => $department_name
            ]);

        return $old_name;
    }
}
