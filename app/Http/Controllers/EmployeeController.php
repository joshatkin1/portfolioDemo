<?php

namespace App\Http\Controllers;

use App\Models\Account as Account;
use App\Models\Employee as Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Validator;

class EmployeeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function changeEmployeeDepartment(Request $request){
        if(session('job_level') < 3){return false;}//ADMIN AUTH FAILED
        $employee_id = $request->id;
        $department_name = $request->department;
        if($employee_id == ""){
            return false;
        }

        Employee::changeEmployeeDepartment($employee_id, $department_name);
        return true;
    }

    public function fetchCompanyEmployeeList(){
        $employeeList =  Employee::fetchCompanyEmployeeList();
        return response($employeeList, 200)
            ->header('Content-Type', 'application/json');
    }

    public function removeEmployeeDepartment(Request $request){
        if(session('job_level') < 3){return false;}//ADMIN AUTH FAILED
        $employee_id = $request->id;
        if($employee_id == ""){
            return false;
        }

        Employee::removeEmployeeDepartment($employee_id);
        return true;
    }

    public function createNewEmployee(Request $request){
        if(session('job_level') < 3){return false;}//ADMIN AUTH FAILED
        $employee = json_decode($request->employee, true);
        intval($employee['job_level']);
        $table = session('database_prefix') . 'team';

        $validator = Validator::make($employee, [
            'employee_name' => ["required", "string", "max:255"],
            'employee_email' => ["required", "email", "unique:" . $table ],
            'employee_id' => ["sometimes", "string" , "unique:" . $table],
            'escalations_access' => ["required", "bool"],
            'job_title' => ["sometimes", "string" , "max:255"],
        ]);

        if ($validator->fails()) {
            $errors = json_encode($validator->errors());
            return response($errors, 422)
                ->header('Content-Type', 'text/json');
        }


        $response = Employee::createNewEmployee($employee);

        return response($response, 200)
            ->header('Content-Type', 'text/plain');
    }

    public function updateEmployee(Request $request){
        if(session('job_level') < 3){return false;}//ADMIN AUTH FAILED

        $employee = json_decode($request->employee, true);
        $id = $employee["id"];

        intval($employee['job_level']);
        $table = session('database_prefix') . 'team';

        $validator = Validator::make($employee, [
            'employee_name' => ["required", "string", "max:255"],
            'employee_email' => ["required", "email" , "unique:".$table.",employee_email,".$id],
            'employee_id' => ["sometimes", "string" , "unique:".$table.",employee_id,".$id],
            'escalations_access' => ["required", "bool"],
            'job_title' => ["sometimes", "string" , "max:255"],
        ]);

        if ($validator->fails()) {
            $errors = json_encode($validator->errors());
            return response($errors, 422)
                ->header('Content-Type', 'text/json');
        }

        $response = Employee::updateEmployee($employee);

        return response($response, 200)
            ->header('Content-Type', 'text/plain');
    }

    public function deleteEmployee(Request $request){
        if(session('job_level') < 3){return false;}//ADMIN AUTH FAILED

        $employee_id = $request->employee_id;

        $response = Employee::deleteEmployee($employee_id);

        Account::decreaseSubscriptionCost();

        return response($response, 200)
            ->header('Content-Type', 'text/plain');

    }
}
