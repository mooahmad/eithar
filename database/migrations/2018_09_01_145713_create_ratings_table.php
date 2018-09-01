<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->integer('service_provider_id')->nullable();
            $table->integer('type')->nullable();
            $table->integer('rating')->nullable();
            $table->longText('rating_description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // relations
        Schema::table('ratings', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('customers')
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
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('ratings');
    }
}
