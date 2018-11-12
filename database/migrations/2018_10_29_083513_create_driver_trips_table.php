<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_trips', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('driver_id')->nullable();
            $table->unsignedInteger('appointment_id')->nullable();
            $table->text('comment')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        // relations
        Schema::table('driver_trips', function (Blueprint $table) {
            $table->foreign('driver_id')
                ->references('id')
                ->on('drivers')
                ->onUpdate('set null')
                ->onDelete('set null');
            $table->foreign('appointment_id')
                ->references('id')
                ->on('service_booking_appointments')
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
        Schema::table('driver_trips', function (Blueprint $table) {
            $table->dropForeign(['driver_id']);
            $table->dropForeign(['appointment_id']);

        });
        Schema::dropIfExists('driver_trips');
    }
}
