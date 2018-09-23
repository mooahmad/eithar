<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('service_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->Integer('is_general')->default(0)->nullable();
            $table->Integer('is_published')->default(0)->nullable();
            $table->Integer('customer_can_view')->default(0)->nullable();
            $table->text('file_path')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        // relations
        Schema::table('medical_reports', function (Blueprint $table) {
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onUpdate('set null')
                ->onDelete('set null');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('set null')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // relations
        Schema::table('medical_reports', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('medical_reports');
    }
}
