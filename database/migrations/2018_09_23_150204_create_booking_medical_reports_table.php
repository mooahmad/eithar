<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingMedicalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_medical_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('service_booking_id')->nullable();
            $table->unsignedInteger('provider_id')->nullable();
            $table->unsignedInteger('medical_report_id')->nullable();
            $table->text('file_path')->nullable();
            $table->Integer('is_approved')->default(0)->nullable();
            $table->Integer('customer_can_view')->default(0)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        // relations
        Schema::table('booking_medical_reports', function (Blueprint $table) {
            $table->foreign('service_booking_id')
                ->references('id')
                ->on('service_bookings')
                ->onUpdate('set null')
                ->onDelete('set null');
            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
                ->onUpdate('set null')
                ->onDelete('set null');
            $table->foreign('medical_report_id')
                ->references('id')
                ->on('medical_reports')
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
        Schema::table('booking_medical_reports', function (Blueprint $table) {
            $table->dropForeign(['service_booking_id']);
            $table->dropForeign(['provider_id']);
            $table->dropForeign(['medical_report_id']);
        });
        Schema::dropIfExists('booking_medical_reports');
    }
}
