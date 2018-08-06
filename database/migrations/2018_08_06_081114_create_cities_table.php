<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id')->nullable();
            $table->string('city_name_ara',100)->nullable();
            $table->string('city_name_eng',100)->nullable();
            $table->string('city_code',100)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        // relations
        Schema::table('cities', function (Blueprint $table) {
            $table->foreign('country_id')
                  ->references('id')
                  ->on('countries')
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
        Schema::table('cities', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
        });
        Schema::dropIfExists('cities');
    }
}
