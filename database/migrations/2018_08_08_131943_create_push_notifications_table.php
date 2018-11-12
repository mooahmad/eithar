<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('provider_id')->nullable();
            $table->string('imei',255)->nullable();
            $table->string('device_type',255)->nullable();
            $table->string('device_language', 255)->nullable();
            $table->string('token',255)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        // relations
        Schema::table('push_notifications', function (Blueprint $table) {
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onUpdate('set null')
                ->onDelete('set null');
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
        Schema::table('push_notifications', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['provider_id']);
        });
        Schema::dropIfExists('push_notifications');
    }
}
