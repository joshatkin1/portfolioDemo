<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRegisterRequest;
use App\Models\CloudSetting;
use App\Models\CloudSubscription as CloudSubscription;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class CompanyRegisterController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('userDeviceAuth');
    }

    final public function companyRegisterView(){
        if(session('company_link') !== null && session('recent_reg') === null){
            return redirect('/app');
        }
        return view('company-register');
    }

    final public function registerCompany(CompanyRegisterRequest $request, Company $company, User $user){
        $name = ucwords(strtolower($request->input("company_name")));
        $type = ucwords(strtolower($request->input("company_industry")));
        $employee_count = 1;

        if(session('company_link')){
            return response('company already linked with this user', 409)
                ->header('Content-Type', 'text/plain');
        }

        $company->master_admin = session('id');
        $company->company_name = $name;
        $company->company_industry = $type;
        if($request->input("company_number") !== null && $request->input("company_number") !== "" ){
            $company->company_number = $request->input("company_number");
        }
        $company->company_email = $request->input("company_email");
        $company->company_tel = $request->input("company_tel");
        $company->employee_count = 1;
        $company->active_subscription = 0;
        $company->storage_amount = 0;
        $company->subscribed_date =  time();
        $company->subscription_cost = 10;

        if( $company->save() ){

            CloudSetting::create(["company_id" => $company->company_id,
                "modify_employees" => 3,
                "manage_storage" => 4,
                "run_schedule" => 3,
                "mfa_login" => true,
                "fresh_password_period" => 90,
                "storage_limit_alert" => 1000000000,
                "edit_employees" => 3,
                "create_tasks" => 2,
                "create_projects" => 2,
                "create_customers" => 2,
                "edit_customers" => 2,
                "view_customer_billing" => 1,
                "customer_account_mfa" => true,
                "crm_term" => "Clients",
                "crm_transaction_term" => "Sale",
                "recruitment_access_level" => 2,
                "recruitment_connect_level" => 3,
                "manage_job_adverts" => 3,
                "supplier_access" => 3,
                "suppliers_managing" => 3]);

            //SET COMPANY LINK SESSION DATA

            $user = User::where('id', session('id'))->first();
            $user->company_link = $company->company_id;
            $user->save();


            $data = [
                ['company_id'=>$company->company_id , 'subscription_name'=> "Schedule"],
                ['company_id'=>$company->company_id , 'subscription_name'=> "Clients"],
                ['company_id'=>$company->company_id , 'subscription_name'=> "Workflow"],
                ['company_id'=>$company->company_id , 'subscription_name'=> "Sales"],
                ['company_id'=>$company->company_id , 'subscription_name'=> "Projects"],
                ['company_id'=>$company->company_id , 'subscription_name'=> "Chat"],
                ['company_id'=>$company->company_id , 'subscription_name'=> "Suppliers"]
            ];

            CloudSubscription::insert($data);



            session(['company_link' => $company->company_id]);

            //CREATE COMPANY DATABASE

            $database_prefix = 'company' . $company->company_id . '_';

            session(['database_prefix' => $database_prefix]);

            $storage_dir = session('database_prefix') . 'storage';

            Storage::makeDirectory('/2Phtt93Ag66Q8f/' . $storage_dir);

            try{

                DB::transaction(function () {

                    Schema::create(session('database_prefix') . 'team', function (Blueprint $table) {
                        $table->engine = 'MyISAM';
                        Schema::defaultStringLength(255);

                        $table->bigIncrements('id');
                        $table->bigInteger('user_id');
                        $table->string('employee_name');
                        $table->string('employee_email');
                        $table->string('employee_id')->nullable();
                        $table->boolean('escalations_access');
                        $table->integer('job_level')->default(1);
                        $table->string('telephone')->nullable();
                        $table->string('job_title')->nullable();
                        $table->string('department')->nullable();
                        $table->boolean('active')->default(0);

                        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                        $table->timestamp('created_at')->useCurrent();
                    });

                    Schema::create(session('database_prefix') . 'departments', function (Blueprint $table) {
                        $table->engine = 'InnoDB';
                        Schema::defaultStringLength(255);

                        $table->bigIncrements('id');
                        $table->string('department_name')->unique();
                        $table->boolean('department_privacy')->default(0);
                        $table->json('department_alerts')->nullable();
                        $table->json('news_feed')->nullable();

                        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                        $table->timestamp('created_at')->useCurrent();
                    });

                    Schema::create(session('database_prefix') . 'schedule', function (Blueprint $table) {
                        $table->engine = 'MyISAM';
                        Schema::defaultStringLength(255);

                        $table->bigIncrements('id')->unsigned();
                        $table->date('date');
                        $table->bigInteger('created_by')->unsigned();
                        $table->json('schedule');

                        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                        $table->timestamp('created_at')->useCurrent();
                    });

                    Schema::create(session('database_prefix') . 'schedule_appointments', function (Blueprint $table) {

                        $table->engine = 'InnoDB';
                        Schema::defaultStringLength(255);

                        $table->bigIncrements('id')->unsigned();
                        $table->bigInteger('appointment_creator')->unsigned();
                        $table->json('appointment_invitees')->nullable();
                        $table->date('appointment_date');
                        $table->dateTime('appointment_start');
                        $table->dateTime('appointment_end');
                        $table->enum('appointment_type', ['Meeting', 'Team Meeting' , 'Training' , 'Team Training' , 'Event' , 'Interview' , 'Miscellaneous'])->default('Meeting');
                        $table->mediumText('appointment_message')->nullable();
                        $table->longText('appointment_recap')->nullable();
                        $table->json('appointment_documents')->nullable();

                        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                        $table->timestamp('created_at')->useCurrent();
                    });

                    Schema::create(session('database_prefix') . 'time_clock', function (Blueprint $table) {

                        $table->engine = 'MyISAM';
                        Schema::defaultStringLength(255);

                        $table->bigIncrements('id')->unsigned();
                        $table->bigInteger('user_id')->unsigned();
                        $table->dateTime('activity_time')->default(DB::raw('CURRENT_TIMESTAMP'));
                        $table->string('activity');

                        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                        $table->timestamp('created_at')->useCurrent();
                    });

                    Schema::create(session('database_prefix') . 'time_off', function (Blueprint $table) {

                        $table->engine = 'InnoDB';
                        Schema::defaultStringLength(255);

                        $table->bigIncrements('id');
                        $table->bigInteger('user_id')->unsigned();
                        $table->bigInteger('created_by')->unsigned();
                        $table->dateTime('confirmed_date')->default(DB::raw('CURRENT_TIMESTAMP'));
                        $table->enum('type', ['Holiday', 'Sick' , 'Maternity' , 'Paternity' , 'Furlough' , 'Sabbatical' , 'Miscellaneous'])->default('Holiday');
                        $table->dateTime('period_start');
                        $table->dateTime('period_end');
                        $table->integer('hours')->nullable();

                        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                        $table->timestamp('created_at')->useCurrent();
                    });

                    Schema::create(session('database_prefix') . 'projects', function (Blueprint $table) {
                        $table->engine = 'InnoDB';
                        Schema::defaultStringLength(255);

                        $table->bigIncrements('project_id');
                        $table->bigInteger('project_leader')->unsigned();
                        $table->string('project_settings');
                        $table->string('project_team')->nullable();
                        $table->string('project_name');
                        $table->string('project_description')->nullable();
                        $table->longText('project_summary')->nullable();
                        $table->date('project_deadline')->nullable();
                        $table->json('project_activity')->nullable();
                        $table->json('project_news')->nullable();
                        $table->string('project_customer')->nullable();
                        $table->string('project_budget')->nullable();
                        $table->json('project_time_management')->nullable();
                        $table->json('project_stages')->nullable();
                        $table->json('project_messages')->nullable();
                        $table->json('project_documents')->nullable();
                        $table->json('project_hiring')->nullable();
                        $table->boolean('projected_billable')->default(0);
                        $table->boolean('project_finished')->default(0);

                        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                        $table->timestamp('created_at')->useCurrent();
                    });

                    Schema::create(session('database_prefix') . 'customers', function (Blueprint $table) {

                        $table->engine = 'InnoDB';
                        Schema::defaultStringLength(255);

                        $table->bigIncrements('customer_id');
                        $table->enum('account_type', ['Business', 'Individual'])->default('Individual');
                        $table->string('account_number')->nullable();
                        $table->string('account_name');
                        $table->string('account_email');
                        $table->string('account_master_user');
                        $table->json('customer_addresses')->nullable();
                        $table->string('account_telephone')->nullable();
                        $table->json('customer_attributes')->nullable();
                        $table->json('customer_projects')->nullable();
                        $table->json('customer_actions')->nullable();
                        $table->json('customer_sales')->nullable();
                        $table->json('business_employees')->nullable();
                        $table->mediumText('account_attachments')->nullable();
                        $table->json('customer_products')->nullable();
                        $table->json('billing_details')->nullable();
                        $table->json('customer_notes')->nullable();
                        $table->json('customer_communications')->nullable();
                        $table->bigInteger('account_manager')->default(-1);
                        $table->json('account_access_history')->nullable();
                        $table->string('customer_rapport')->nullable();
                        $table->json('customer_responses')->nullable();
                        $table->json('customer_requests')->nullable();
                        $table->boolean('account_privacy')->default(0);
                        $table->boolean('account_locked')->default(0);
                        $table->boolean('account_active')->default(1);

                        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                        $table->timestamp('created_at')->useCurrent();
                    });

                    Schema::create(session('database_prefix') . 'transactions', function (Blueprint $table) {

                        $table->engine = 'InnoDB';
                        Schema::defaultStringLength(255);

                        $table->bigIncrements('transaction_id');
                        $table->string('transaction_no')->unique();
                        $table->string('transaction_ref')->nullable();
                        $table->bigInteger('transaction_owner');
                        $table->json('transaction_owner_owner_list')->nullable();
                        $table->string('transaction_type');
                        $table->string('transaction_email')->nullable();
                        $table->bigInteger('customer_link')->nullable();
                        $table->bigInteger('project_id')->nullable();
                        $table->bigInteger('transaction_link')->nullable();
                        $table->string('subtotal')->nullable();
                        $table->string('tax')->nullable();
                        $table->string('total')->nullable();
                        $table->string('received')->nullable();
                        $table->string('due')->nullable();
                        $table->string('received_payment_amount')->nullable();
                        $table->json('cc_emails')->nullable();
                        $table->json('transaction_lines')->nullable();
                        $table->string('vatAccountingType')->nullable();
                        $table->string('transaction_created_date')->useCurrent();
                        $table->string('transaction_due_date')->nullable();
                        $table->string('transaction_paid_date')->nullable();
                        $table->mediumText('contract_terms')->nullable();
                        $table->string('transaction_attachment_key')->nullable();
                        $table->boolean('transaction_open')->default(1);

                        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                        $table->timestamp('created_at')->useCurrent();

                        $table->index(['transaction_type', 'due', 'transaction_open'], 'open_transaction_finder_unique');
                    });

                    Schema::create(session('database_prefix') . 'products', function (Blueprint $table) {

                        $table->engine = 'InnoDB';
                        Schema::defaultStringLength(255);

                        $table->bigIncrements('id');
                        $table->bigInteger('product_creator');
                        $table->enum('product_type', ['Product' ,'Subscription', 'Service' , 'Consultation' , 'Sales' , 'Miscellaneous'])->default('Product');
                        $table->string('product_name')->unique();
                        $table->string('product_number')->nullable();
                        $table->string('product_description')->nullable();
                        $table->float('product_cost')->unsigned()->default(0.00);
                        $table->bigInteger('stock_amount')->default(0);
                        $table->string('default_vat')->default("none");
                        $table->json('product_sales_history')->nullable();
                        $table->boolean('product_active')->default(1);

                        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                        $table->timestamp('created_at')->useCurrent();
                    });

                    Schema::create(session('database_prefix') . 'suppliers', function (Blueprint $table) {

                        $table->engine = 'InnoDB';
                        Schema::defaultStringLength(255);

                        $table->bigIncrements('id');
                        $table->bigInteger('account_manager');
                        $table->string('supplier_type');
                        $table->string('supplier_name');
                        $table->json('supplier_email');
                        $table->json('supplier_telephone');
                        $table->json('supplier_employees');
                        $table->json('supplier_address');
                        $table->json('supplier_notes');
                        $table->json('supplier_attachments');
                        $table->float('billing_rate');
                        $table->float('supplier_balance');
                        $table->string('account_number');
                        $table->string('terms');

                        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                        $table->timestamp('created_at')->useCurrent();
                    });

                    Schema::create(session('database_prefix') . 'supplier_transactions', function (Blueprint $table) {

                        $table->engine = 'MyISAM';
                        Schema::defaultStringLength(255);

                        $table->bigIncrements('id');
                        $table->bigInteger('supplier_id');
                        $table->json('transaction_details');
                        $table->float('transaction_amount');
                        $table->float('transaction_paid');
                        $table->bigInteger('transaction_date');
                        $table->bigInteger('transaction_terms');

                        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                        $table->timestamp('created_at')->useCurrent();
                    });

                    Schema::create(session('database_prefix') . 'messenger', function (Blueprint $table) {

                        $table->engine = 'MyISAM';
                        Schema::defaultStringLength(255);

                        $table->bigIncrements('id');
                        $table->bigInteger('chat_creator');
                        $table->string('chat_title');
                        $table->string('chat_description')->nullable();
                        $table->mediumText('chat_users');
                        $table->json('chat_messages')->nullable();
                        $table->json('chat_documents');
                        $table->enum('chat_type', ['private', 'global'])->default('private');
                        $table->boolean('chat_privacy')->default(0);
                        $table->timestamp('chat_users_access_updated');

                        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                        $table->timestamp('created_at')->useCurrent();
                    });

                    Schema::create(session('database_prefix') . 'escalations', function (Blueprint $table) {

                        $table->engine = 'InnoDB';
                        Schema::defaultStringLength(255);

                        $table->bigIncrements('id');
                        $table->bigInteger('customer_id');
                        $table->dateTime('escalation_created');
                        $table->bigInteger('escalation_creator');
                        $table->string('escalation_team');
                        $table->bigInteger('escalation_owner')->nullable();
                        $table->json('escalation_owner_list')->nullable();
                        $table->string('escalation_name');
                        $table->string('escalation_type');
                        $table->string('escalation_description')->nullable();
                        $table->json('escalation_notes')->nullable();
                        $table->enum('escalation_stage', ['new', 'received' , 'in progress' , 'hold' , 'resolved' , 'rejected' ,'closed' , 'reopened'])->default('new');
                        $table->string('escalation_outcome')->nullable();
                        $table->boolean('escalation_closed')->default(false);

                        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                        $table->timestamp('created_at')->useCurrent();
                    });

                    Schema::create(session('database_prefix') . 'workflow', function (Blueprint $table) {

                        $table->engine = 'InnoDB';
                        Schema::defaultStringLength(255);

                        $table->bigIncrements('id');
                        $table->bigInteger('creator');
                        $table->bigInteger('owner');
                        $table->json('task_owner_list');
                        $table->string('task_name')->nullable();
                        $table->string('task_description')->nullable();
                        $table->string('task_stage');
                        $table->json('task_notes')->nullable();
                        $table->bigInteger('task_timer')->default(0);
                        $table->boolean('task_active')->default(0);
                        $table->boolean('task_completion')->default(0);

                        $table->bigInteger('task_link')->nullable();
                        $table->bigInteger('project_link')->nullable();

                        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                        $table->timestamp('created_at')->useCurrent();
                    });

                    Schema::create(session('database_prefix') . 'notifications', function (Blueprint $table) {

                        $table->engine = 'MyISAM';
                        Schema::defaultStringLength(255);

                        $table->bigIncrements('id');
                        $table->bigInteger('employee_id');
                        $table->string('notification_type');
                        $table->string('notification_name');
                        $table->string('notification_text');
                        $table->string('notification_external_link')->nullable();

                        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                        $table->timestamp('created_at')->useCurrent();
                    });

                    Schema::create(session('database_prefix') . 'audit_log', function (Blueprint $table) {

                        $table->engine = 'MyISAM';
                        Schema::defaultStringLength(255);

                        $table->bigIncrements('id');
                        $table->bigInteger('employee_id')->nullable();
                        $table->dateTime('action_time')->default(DB::raw('CURRENT_TIMESTAMP'));
                        $table->string('action_type')->nullable();
                        $table->string('action')->nullable();

                        $table->bigInteger('project')->nullable();
                        $table->bigInteger('task')->nullable();
                        $table->bigInteger('account')->nullable();
                        $table->bigInteger('document')->nullable();
                        $table->bigInteger('escalation')->nullable();
                        $table->bigInteger('job')->nullable();
                        $table->bigInteger('employee')->nullable();
                        $table->bigInteger('setting')->nullable();

                        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                        $table->timestamp('created_at')->useCurrent();
                    });

                    Schema::create(session('database_prefix') . 'customer_complaints', function (Blueprint $table) {

                        $table->engine = 'MyISAM';
                        Schema::defaultStringLength(255);

                        $table->bigIncrements('id');
                        $table->dateTime('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
                        $table->bigInteger('complaint_creator');
                        $table->bigInteger('customer')->nullable();
                        $table->string('customer_details')->nullable();
                        $table->json('complaint_owners')->nullable();
                        $table->bigInteger('complaint_employee')->nullable();
                        $table->string('complaint_type');
                        $table->mediumText('complaint_reason');
                        $table->json('complaint_notes')->nullable();

                        $table->boolean('complaint_resolved')->default(0);
                        $table->dateTime('complaint_resolve_date')->nullable();
                        $table->mediumText('complaint_outcome')->nullable();

                        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                        $table->timestamp('created_at')->useCurrent();
                    });

                    DB::commit();

                }, 4);


                $table = session('database_prefix') . 'team';
                $job_title = session('job_title') ? session('job_title') : 'Managing Director';

                $response = DB::table($table)->insert(
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

                session(['job_level' => 4 , 'recent_reg' => true]);

                //RETURN RESPONSE
                return response('Successully Registered Company',200);

            } catch (Exception $e) {
                return response($e, 400)
                    ->header('Content-Type', 'text/plain');
            }

            return response('error', 400)
                ->header('Content-Type', 'text/plain');

        }
    }
}
