<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',255);
            $table->string('email',255)->unique();
            $table->string('job_title',255)->nullable();
            $table->integer('company_link')->nullable();
            $table->string('telephone')->nullable();
            $table->string('password');
            $table->boolean('logged_in');
            $table->integer('failed_logins');
            $table->integer('last_password_change');
            $table->boolean('email_verified')->nullable();
            $table->json('verified_device_keys')->nullable();
            $table->integer('joined_date');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->useCurrent();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
