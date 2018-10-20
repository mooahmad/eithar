<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJoinUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('join_us', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name', 255);
            $table->string('email', 255);
            $table->string('mobile_number', 255);
            $table->string('national_id', 255);
            $table->unsignedInteger('city_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('join_us', function (Blueprint $table) {
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
        Schema::table('join_us', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
        });
        Schema::dropIfExists('join_us');
    }
}
