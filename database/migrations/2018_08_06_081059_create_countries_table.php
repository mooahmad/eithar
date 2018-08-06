<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('capital',100)->nullable();
            $table->string('citizenship',100)->nullable();
            $table->string('country_code',100)->nullable();
            $table->string('currency',100)->nullable();
            $table->string('currency_code',100)->nullable();
            $table->string('currency_sub_unit',100)->nullable();
            $table->string('currency_symbol',100)->nullable();
            $table->string('currency_decimals',100)->nullable();
            $table->string('full_name',100)->nullable();
            $table->string('iso_3166_2',100)->nullable();
            $table->string('iso_3166_3',100)->nullable();
            $table->string('country_name_eng',100)->nullable();
            $table->string('country_name_ara',100)->nullable();
            $table->string('region_code',100)->nullable();
            $table->string('sub_region_code',100)->nullable();
            $table->string('eea',100)->nullable();
            $table->string('calling_code',100)->nullable();
            $table->string('flag',100)->nullable();
            $table->integer('added_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
