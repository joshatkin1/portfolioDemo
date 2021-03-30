<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloudEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cloud_employees', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('user_id');
            $table->integer('job_level')->default(1);
            $table->string('employee_name')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('employee_email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('job_title')->nullable();
            $table->boolean('escalations_access')->nullable();
            $table->integer('department_id')->nullable();
            $table->boolean('active')->default(0);
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
        Schema::dropIfExists('cloud_employees');
    }
}
