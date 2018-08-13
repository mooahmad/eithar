<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_cities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('provider_id')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        // relations
        Schema::table('provider_cities', function (Blueprint $table) {
            $table->foreign('provider_id')
                  ->references('id')
                  ->on('providers')
                  ->onUpdate('set null')
                  ->onDelete('set null');

        });
        Schema::table('provider_cities', function (Blueprint $table) {
            $table->foreign('city_id')
                  ->references('id')
                  ->on('cities')
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
        Schema::table('provider_cities', function (Blueprint $table) {
            $table->dropForeign(['provider_id']);
            $table->dropForeign(['city_id']);
        });
        Schema::dropIfExists('provider_cities');
    }
}
