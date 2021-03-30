<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloudSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cloud_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('modify_employees');
            $table->integer('manage_storage');
            $table->integer('run_schedule');
            $table->boolean('mfa_login');
            $table->integer('fresh_password_period');
            $table->integer('storage_limit_alert');
            $table->integer('edit_employees');
            $table->integer('create_tasks');
            $table->integer('create_projects');
            $table->integer('create_customers');
            $table->integer('edit_customers');
            $table->integer('view_customer_billing');
            $table->integer('customer_account_mfa');
            $table->string('crm_term');
            $table->string('crm_transaction_term');
            $table->integer('recruitment_access_level');
            $table->integer('recruitment_connect_level');
            $table->integer('manage_job_adverts');
            $table->string('cloud_chat_storage')->default('manual');
            $table->string('projects_storage')->default('manual');
            $table->string('document_storage')->default('manual');
            $table->integer('supplier_access');
            $table->integer('suppliers_managing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cloud_settings');
    }
}
