<?php

namespace App\Models;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{

    protected static function switchCompanyEmployeesDepartment($old_name, $department_name){
        $employees = self::fetchCompanyEmployeeList();
        foreach($employees as $employee){
            if($employee->department == $old_name){
                self::changeEmployeeDepartment($employee->id, $department_name);
            }
        }
        return true;
    }

    protected static function changeEmployeeDepartment($id , $dep){
        $table = session('database_prefix') . 'team';
        $id = intval($id);

        $result = DB::table($table)
            ->where('id', "=" , $id)
            ->update(
                [
                    'department' => $dep,
                ]
            );

        return $result;
    }

    protected static function fetchCompanyEmployeeList(){
        $table = session('database_prefix') . 'team';

        $result = DB::table($table)
            ->get();

        return $result;
    }

    protected static function removeEmployeeDepartment($id){
        $table = session('database_prefix') . 'team';

        $result = DB::table($table)
            ->where('id', "=" , $id)
            ->update(
                [
                    'department' => "",
                ]
            );

        return $result;
    }

    protected static function fetchSpecificEmployee($id){
        $table = session('database_prefix') . 'team';

        $user = DB::table($table)
            ->where('id' , '=', $id)
            ->first();

        return $user;
    }

    protected static function createNewEmployee($emp){
        $table = session('database_prefix') . 'team';

        $name = $emp["employee_name"];
        $name = ucwords(strtolower($name));

        $result = DB::table($table)
            ->insertGetId(
                [
                    'user_id' => 0,
                    'employee_name' => $name,
                    'employee_email' => $emp["employee_email"],
                    'employee_id' => $emp["employee_id"] ,
                    'escalations_access' => $emp["escalations_access"],
                    'job_level' => $emp["job_level"],
                    'telephone' => $emp["telephone"],
                    'job_title' => $emp["job_title"],
                    'department' => $emp["department"],
                    'active' => 0,
                ]
            );

        Account::increaseSubscriptionCost();

        return $result;
    }

    protected static function updateEmployee($employee){
        $table = session('database_prefix') . 'team';
        $id = $employee["id"];

        $name = $employee["employee_name"];
        $name = ucwords(strtolower($name));

        $result = DB::table($table)
            ->where('id', "=" , $id)
            ->update(
                [
                    'employee_name' => $name,
                    'employee_email' => $employee["employee_email"],
                    'employee_id' => $employee["employee_id"] ,
                    'escalations_access' => $employee["escalations_access"],
                    'job_level' => $employee["job_level"],
                    'telephone' => $employee["telephone"],
                    'job_title' => $employee["job_title"],
                    'department' => $employee["department"],
                ]
            );

        return $result;
    }

    protected static function deleteEmployee($employee_id){
        $table = session('database_prefix') . 'team';

        $result = DB::table($table)
            ->where('id' , '=' , $employee_id)
            ->delete();

        return $result;
    }
}
