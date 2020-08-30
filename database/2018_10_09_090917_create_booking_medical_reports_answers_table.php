<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingMedicalReportsAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_medical_reports_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('booking_report_id')->nullable();
            $table->unsignedInteger('report_question_id')->nullable();
            $table->string('answer', 255);
            $table->string('title_ar', 255);
            $table->string('title_en', 255);
            $table->integer('type')->nullable();
            $table->string('options_ar', 255);
            $table->string('options_en', 255);
            $table->integer('is_required')->nullable();
            $table->integer('order')->nullable();
            $table->integer('pagination')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        // relations
        Schema::table('booking_medical_reports_answers', function (Blueprint $table) {
            $table->foreign('booking_report_id')
                ->references('id')
                ->on('booking_medical_reports')
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
        Schema::table('booking_medical_reports_answers', function (Blueprint $table) {
            $table->dropForeign(['booking_report_id']);
        });
        Schema::dropIfExists('booking_medical_reports_answers');
    }
}
