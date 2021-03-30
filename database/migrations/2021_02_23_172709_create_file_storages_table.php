<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_storages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('file_key')->unique();
            $table->string('file_name')->nullable();
            $table->bigInteger('company_link');
            $table->bigInteger('project_link')->nullable();
            $table->bigInteger('customer_link')->nullable();
            $table->boolean('file_privacy');
            $table->boolean('permanent_file');
            $table->bigInteger('uploaded_timestamp');
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
        Schema::dropIfExists('file_storages');
    }
}
