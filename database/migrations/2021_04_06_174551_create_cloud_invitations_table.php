<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloudInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cloud_invitations', function (Blueprint $table) {
            $table->id();
            $table->string('invitation_key');
            $table->integer('company_id');
            $table->integer('user_id');
            $table->string('invited_by');
            $table->boolean('responsed')->default(0);
            $table->boolean('response')->nullable();
            $table->dateTime('response_sent')->nullable();
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
        Schema::dropIfExists('cloud_invitations');
    }
}
