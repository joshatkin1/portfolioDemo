<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloudAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cloud_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->boolean('active_subscription')->default(0);
            $table->bigInteger('storage_amount')->default(0.5);
            $table->dateTime('subscribed_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->integer('subscription_cost')->default(0);
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
        Schema::dropIfExists('cloud_accounts');
    }
}
