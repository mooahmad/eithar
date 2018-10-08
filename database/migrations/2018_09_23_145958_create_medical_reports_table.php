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
            $table->string('title_ar', 255);
            $table->string('title_en', 255);
            $table->integer('type')->nullable();
            $table->longText('type_description')->nullable();
            $table->integer('max_limit')->nullable();
            $table->string('options_ar', 255);
            $table->string('options_en', 255);
            $table->integer('is_required')->nullable();
            $table->integer('order')->nullable();
            $table->integer('pagination')->nullable();
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
        });
        Schema::dropIfExists('medical_reports');
    }
}
