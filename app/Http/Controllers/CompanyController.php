<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use App\Models\Company;
use App\Models\Employee;
use Session;
use Validator;
use Exception;

class CompanyController extends AppController
{
    public function __construct(){
        parent::__construct();
    }

    final public function closeCompanyDepartment(Request $request){
        if(session('job_level') < 3){return false;}//MASTER ADMIN AUTH FAILED

        $department_id =  $request->department_id;
        $department_swap =   $request->department_swap;

        $old_name = Company::deleteCompanyDepartment($department_id);

        Employee::switchCompanyEmployeesDepartment($old_name, $department_swap);

        return $old_name;
    }

    final public function changeCompanyDepartmentName(Request $request){
        if(session('job_level') < 3){return false;}//MASTER ADMIN AUTH FAILED
        $department_id = $request->department_id;
        $department_name = $request->department_name;

        $old_name = Company::changeCompanyDepartmentName($department_id, $department_name);
        $response = Employee::switchCompanyEmployeesDepartment($old_name, $department_name);

        return response($old_name, 200)
            ->header('Content-Type', 'text/plain');
    }

    final public function toggleDepartmentPrivacySetting(Request $request){
        if(session('job_level') < 3){return false;}//MASTER ADMIN AUTH FAILED
        $department_id = $request->department_id;
        $response = Company::toggleDepartmentPrivacySetting($department_id);

        return response($response, 200)
            ->header('Content-Type', 'text/plain');
    }

    final public function fetchRecruitmentData(){
        $response = Company::fetchRecruitmentData();

        return response($response, 200)
            ->header('Content-Type', 'text/plain');
    }

    final public function createCompanyDepartment(Request $request){

        if(session('job_level') < 3){return false;}//ADMIN AUTH FAILED

        $department_name = $request->department_name;

        $result = Company::createNewDepartment($department_name);
        return response($result, 200)
            ->header('Content-Type', 'text/plain');
    }

    final public function deleteCompanyDepartment(Request $request){

        if(session('job_level') < 3){return false;}//ADMIN AUTH FAILED

        $department_id = $request->department_id;

        $result = Company::deleteCompanyDepartment($department_id);

        return response($result, 200)
            ->header('Content-Type', 'text/plain');
    }

    final public function getCompanyDepartmentList(){
        $departmentList =  Company::departmentList();
        return response($departmentList, 200)
            ->header('Content-Type', 'application/json');
    }

    final public function viewSetUpCompany(){
        if(session('company_link') && session('recent_reg')){
            return view('/companyRegister-setup');
        }else{
            return view('/selectapp');
        }
    }
}
