<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_services', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('provider_id')->nullable();
            $table->unsignedInteger('service_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        // relations
        Schema::table('provider_services', function (Blueprint $table) {
            $table->foreign('provider_id')
                  ->references('id')
                  ->on('providers')
                  ->onUpdate('set null')
                  ->onDelete('set null');

        });
        Schema::table('provider_services', function (Blueprint $table) {
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
        Schema::table('provider_services', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropForeign(['provider_id']);
        });
        Schema::dropIfExists('provider_services');
    }
}
