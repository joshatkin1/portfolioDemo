<?php

namespace App\Models;

use App\Models\Company as Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JobAdvert extends Model
{
    public $advert_company_name = "";
    public $advert_company_industry = "";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "company_link",
        "job_advert_creator",
        "job_position",
        "job_location",
        "job_salary_start",
        "job_salary_end",
        "job_contract_type",
        "job_description",
        "job_benefits",
        "job_experience",
        "job_skill_requirements",
        "job_advert_active",
        "job_advert_paid",
        "job_posted_date",
        "application_deadline",
        "job_reference"
    ];

    /**
     * @var array
     */
    protected $casts = [
        "job_benefits" => "array",
        "job_experience" => "array",
        "job_skill_requirements" => "array",
    ];

    public function __construct(){
        parent::__construct();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        $class = Company::class;
        $class::$staticMakeHidden = [
            'employee_count',
            'company_number',
            'company_employees',
            'master_admin',
            'company_email',
            'company_tel',
            'app_subscriptions',
            'app_settings',
            'company_departments',
            'subscription_cost',
            'recruitment_details',
            'connection_tokens',
            'active_subscription',
            'created_at',
            'storage_amount',
            'subscribed_date',
            'updated_at'
        ];

        return $this->belongsTo($class, 'company_link', 'id', 'companyRegister');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    final protected static function fetchCompanyActiveJobAdverts(){
        $company_link = session('company_link');

        $result = DB::table('job_adverts')
            ->select('*')
            ->where('advert_open', '=', 1)
            ->where('company_link', '=' , $company_link)
            ->get();

        return $result;
    }

    final protected static function deleteJobAdvert($advert_id){
        $company_link = session('company_link');

        $result = DB::table('job_adverts')
            ->where('company_link', '=', $company_link)
            ->where('advert_id', '=' , $advert_id)
            ->delete();

        return $result;
    }
}
