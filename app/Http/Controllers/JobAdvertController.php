<?php

namespace App\Http\Controllers;

use App\Models\JobAdvert as JobAdvert;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobAdvertController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    final public function updateJobAdvert(Request $request){
        //!!! NEED TO CHANGE THIS TO A GATE REFERENCING THE COMPANY SETTINGS FOR MIN JOB LEVEL REQUIRMENT !!
        if(session('job_level') < 3){return false;}//MASTER ADMIN AUTH FAILED

        $job_details = json_decode($request->job_advert, true);

        $today = Carbon::today();
        $one_week = $today->addDays(6);

        $validator = Validator::make($job_details, [
            'job_position' => ["required", "alpha_num", "max:255"],
            'job_location' => ["required", "max:255"],
            'job_salary_start' => ["required", "integer"],
            'job_salary_end' => ["required", "integer"],
            'job_contract_type' => ["required", Rule::in(["full-time", "part-time", "contract"])],
            'job_description' => ["required"],
            'job_advert_paid' => ["required", "boolean"],
            'application_deadline' => ["required", "date", "after:".$one_week]
        ]);

        if ($validator->fails()) {
            $errors = json_encode($validator->errors());
            return response($errors, 422)
                ->header('Content-Type', 'text/json');
        }

        $salary_start = $job_details["job_salary_start"];
        $salary_end = $job_details["job_salary_end"];
        // $job_skill_requirements = json_encode($job_details["job_skill_requirements"]);

        $job_advert = JobAdvert::find($job_details["id"]);

        $job_advert->job_position = $job_details["job_position"];
        $job_advert->job_location = $job_details["job_location"];
        $job_advert->job_salary_start = $salary_start;
        $job_advert->job_salary_end = $salary_end;
        $job_advert->job_contract_type = $job_details["job_contract_type"];
        $job_advert->job_description = $job_details["job_description"];
        $job_advert->job_benefits = $job_details["job_benefits"];
        $job_advert->job_experience = $job_details["job_experience"];
        $job_advert->job_skill_requirements = $job_details["job_skill_requirements"];
        $job_advert->application_deadline = $job_details["application_deadline"];
        $job_advert->job_reference = $job_details["job_reference"];

        $job_advert->save();

        $response = json_encode($job_advert);

        return $response;
    }

    final public function createJobAdvert(Request $request){
        if(session('job_level') < 3){return false;}//MASTER ADMIN AUTH FAILED
        $job_details = json_decode($request->job_advert, true);

        $today = Carbon::today();
        $one_week = $today->addDays(6);

        $validator = Validator::make($job_details,[
            'job_position' => ["required","string", "max:255"],
            'job_location' => ["required", "max:255"],
            'job_salary_start' => ["required", "integer"],
            'job_salary_end' => ["required", "integer"],
            'job_contract_type' => ["required", Rule::in(["Full-time", "Part-time", "Contract"])],
            'job_advert_paid' => ["required", "boolean"],
            'job_description' => ["required"],
            'application_deadline' => ["required", "date", "after:".$one_week]
        ]);

        if ($validator->fails()) {
            $errors = json_encode($validator->errors());
            return response($errors, 422)
                ->header('Content-Type', 'text/json');
        }

        $job_skill_requirements = json_encode($job_details["job_skill_requirements"]);

        $company_id = session('company_link');
        $id = session('id');
        $salary_start = intval($job_details["job_salary_start"]);
        $salary_end = intval($job_details["job_salary_end"]);

        $job_advert = new JobAdvert;
        $job_advert->company_link = $company_id;
        $job_advert->job_advert_creator = $id;
        $job_advert->job_position = ucwords($job_details["job_position"]);
        $job_advert->job_location = $job_details["job_location"];
        $job_advert->job_salary_start = $salary_start;
        $job_advert->job_salary_end = $salary_end;
        $job_advert->job_contract_type = $job_details["job_contract_type"];
        $job_advert->job_description = $job_details["job_description"];
        $job_advert->job_benefits = $job_details["job_benefits"];
        $job_advert->job_experience = $job_details["job_experience"];
        $job_advert->job_skill_requirements = $job_skill_requirements;
        $job_advert->job_advert_active = true;
        $job_advert->job_advert_paid = $job_details["job_advert_paid"];
        $job_advert->job_posted_date =  date("Y-m-d h:s");
        $job_advert->application_deadline = $job_details["application_deadline"];
        $job_advert->job_reference = $job_details["job_reference"];
        $job_advert->job_advert_paid = false;
        $job_advert->job_advert_active = 1;

        $job_advert->advert_company_name = $job_advert->company->company_name;
        $job_advert->advert_company_industry = $job_advert->company->company_industry;

        if( $job_advert->save() ){
            $job_advert = json_encode($job_advert);
            return response($job_advert, 200)
                ->header('Content-Type', 'text/plain');
        }else{
            return response('Failed to save job advert', 400)
                ->header('Content-Type', 'text/plain');
        }
    }

    final public static function fetchCompanyActiveJobAdverts(){
        //!!! NEED TO CHANGE THIS TO A GATE REFERENCING THE COMPANY SETTINGS FOR MIN JOB LEVEL REQUIRMENT !!
        if(session('job_level') < 3){return false;}//MASTER ADMIN AUTH FAILED

        $response = JobAdvert::with('companyRegister')
            ->where('advert_open', '=', 1)
            ->where('company_link', '=', session('company_link'))
            ->latest()
            ->get();

        $response = json_encode($response);

        return response($response, 200)
            ->header('Content-Type', 'text/plain');
    }

    final public function deleteJobAdvert(Request $request){

        $advert_id = intval($request->job_advert_id);

        //!!! NEED TO CHANGE THIS TO A GATE REFERENCING THE COMPANY SETTINGS FOR MIN JOB LEVEL REQUIRMENT !!
        if(session('job_level') < 3 && session('id' !== $advert_id->job_advert_creator)){return false;}//MASTER ADMIN AUTH FAILED

        $response = JobAdvert::find($advert_id)->delete();

        return response($response, 200)
            ->header('Content-Type', 'text/plain');
    }
}
