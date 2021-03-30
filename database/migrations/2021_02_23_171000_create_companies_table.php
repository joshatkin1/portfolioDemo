<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('company_id');
            $table->integer('master_admin');
            $table->string('company_name');
            $table->string('company_industry');
            $table->string('company_number')->nullable();
            $table->string('company_email');
            $table->string('company_tel')->nullable();
            $table->json('company_employees')->nullable();
            $table->integer('employee_count')->default(1);
            $table->boolean('active_subscription')->default(0);
            $table->bigInteger('storage_amount')->default(0);
            $table->integer('subscribed_date')->default(0);
            $table->integer('subscription_cost')->default(10);
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
