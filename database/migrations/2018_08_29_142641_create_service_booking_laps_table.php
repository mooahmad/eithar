<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceBookingLapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_booking_laps', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('service_booking_id')->nullable();
            $table->unsignedInteger('service_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // relations
        Schema::table('service_booking_laps', function (Blueprint $table) {
            $table->foreign('service_booking_id')
                ->references('id')
                ->on('service_bookings')
                ->onUpdate('set null')
                ->onDelete('set null');

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
        Schema::table('service_booking_laps', function (Blueprint $table) {
            $table->dropForeign(['service_booking_id']);
            $table->dropForeign(['service_id']);
        });
        Schema::dropIfExists('service_booking_laps');
    }
}
