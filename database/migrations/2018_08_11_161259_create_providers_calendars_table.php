<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers_calendars', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('provider_id')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('number_of_booking')->nullable();
            $table->integer('is_available')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        // relations
        Schema::table('providers_calendars', function (Blueprint $table) {
            $table->foreign('provider_id')
                  ->references('id')
                  ->on('providers')
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
        Schema::table('provider_services', function (Blueprint $table) {
            $table->dropForeign(['provider_id']);
        });
        Schema::dropIfExists('providers_calendars');
    }
}
