<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceBookingAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_booking_appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('service_booking_id')->nullable();
            $table->integer('slot_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // relations
        Schema::table('service_booking_appointments', function (Blueprint $table) {
            $table->foreign('service_booking_id')
                ->references('id')
                ->on('service_bookings')
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
        Schema::table('service_booking_appointments', function (Blueprint $table) {
            $table->dropForeign(['service_booking_id']);
        });
        Schema::dropIfExists('service_booking_appointments');
    }
}
