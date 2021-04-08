<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRegisterRequest;
use App\Models\Company;
use App\Policies\CompanyPolicy;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Throwable;

class CompanyRegisterController extends AppController
{
    public function __construct(){
        parent::__construct();
        $this->authorizeResource(Company::class, 'company');
    }

    public function create(CompanyRegisterRequest $request, Company $company, User $user){

            try {
                $company->create($request, $user);

                $table = 'company' . session('company_link') . '_' . 'team';
                $job_title = session('job_title') ? session('job_title') : 'Managing Director';

                DB::table($table)->insert(
                    [
                        'user_id' => session('id'),
                        'employee_name' => session('name'),
                        'employee_email' => session('email'),
                        'employee_id' => 1,
                        'escalations_access' => 1,
                        'job_level' => 4,
                        'telephone' => "",
                        'job_title' => $job_title,
                        'active' => 1,
                    ]
                );

                Session::put(['job_level' => 4, 'recent_reg' => true]);

            } catch (\Exception $exception) {
                DB::rollBack();
                return response($exception->getMessage(), 500)
                    ->header('Content-Type', 'text/plain');
            } catch (Throwable $exception) {
                DB::rollBack();
                return response($exception->getMessage(), 500)
                    ->header('Content-Type', 'text/plain');
            }

            //RETURN RESPONSE
            $company = Company::where('company_id', '=', session('company_link'))->first();
            return response()->json($company, 200);

    }
}
