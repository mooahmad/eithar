<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('currency_id')->nullable();
            $table->integer('type')->nullable();
            $table->longText('type_desc')->nullable();
            $table->string('name_ar', 255)->nullable();
            $table->string('name_en', 255)->nullable();
            $table->longText('desc_ar')->nullable();
            $table->longText('desc_en')->nullable();
            $table->string('profile_picture_path', 255)->nullable();
            $table->string('profile_video_path', 255)->nullable();
            $table->string('benefits_ar', 255)->nullable();
            $table->string('benefits_en', 255)->nullable();
            $table->integer('no_of_visits')->default(0);
            $table->integer('visits_per_week')->default(0);
            $table->double('price')->nullable();
            $table->integer('visit_duration')->nullable();
            $table->integer('time_before_next_visit')->nullable();
            $table->integer('is_active_service')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->integer('no_of_followers')->default(0);
            $table->integer('no_of_likes')->default(0);
            $table->integer('no_of_views')->default(0);
            $table->integer('no_of_ratings')->default(0);
            $table->integer('no_of_reviews')->default(0);
            $table->integer('appear_on_website')->nullable();
            $table->integer('added_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        // relations
        Schema::table('services', function (Blueprint $table) {
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onUpdate('set null')
                  ->onDelete('set null');

            $table->foreign('country_id')
                  ->references('id')
                  ->on('countries')
                  ->onUpdate('set null')
                  ->onDelete('set null');

            $table->foreign('currency_id')
                  ->references('id')
                  ->on('currencies')
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
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['country_id']);
            $table->dropForeign(['currency_id']);
        });
        Schema::dropIfExists('services');
    }
}
