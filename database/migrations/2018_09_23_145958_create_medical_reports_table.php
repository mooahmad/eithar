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
            $table->unsignedInteger('provider_id')->nullable();
            $table->string('title_ar', 255)->nullable();
            $table->string('title_en', 255)->nullable();
            $table->integer('is_general')->nullable();
            $table->integer('is_published')->nullable();
            $table->Integer('customer_can_view')->default(0)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        // relations
        Schema::table('medical_reports', function (Blueprint $table) {

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

        });
        Schema::dropIfExists('medical_reports');
    }
}
