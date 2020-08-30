<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushNotificationsTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_notifications_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type');
            $table->string('title_ar', 255)->nullable();
            $table->string('title_en', 255)->nullable();
            $table->string('desc_ar', 255)->nullable();
            $table->string('desc_en', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('push_notifications_types', function (Blueprint $table) {
            $table->unique('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('push_notifications_types', function (Blueprint $table) {
            $table->dropUnique(['type']);
        });
        Schema::dropIfExists('push_notifications_types');
    }
}
