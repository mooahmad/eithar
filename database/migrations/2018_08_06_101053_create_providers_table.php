<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('currency_id')->nullable();
            $table->string('title_ar', 255)->nullable();
            $table->string('title_en', 255)->nullable();
            $table->string('first_name_ar', 255)->nullable();
            $table->string('first_name_en', 255)->nullable();
            $table->string('last_name_ar', 255)->nullable();
            $table->string('last_name_en', 255)->nullable();
            $table->string('email')->nullable();
            $table->integer('email_verified')->default(0);
            $table->string('email_code', 8)->nullable();
            $table->string('mobile_number')->nullable();
            $table->integer('mobile_verified')->default(0);
            $table->string('mobile_code', 8)->nullable();
            $table->string('password');
            $table->string('forget_password_code', 255)->nullable();
            $table->string('speciality_area_ar', 255)->nullable();
            $table->string('speciality_area_en', 255)->nullable();
            $table->string('profile_picture_path', 255)->nullable();
            $table->string('video', 255)->nullable();
            $table->double('price')->nullable();
            $table->double('rating')->nullable();
            $table->longText('about_ar')->nullable();
            $table->longText('about_en')->nullable();
            $table->string('experience_ar', 255)->nullable();
            $table->string('experience_en', 255)->nullable();
            $table->string('education_ar', 255)->nullable();
            $table->string('education_en', 255)->nullable();
            $table->integer('no_of_followers')->default(0);
            $table->integer('no_of_likes')->default(0);
            $table->integer('no_of_views')->default(0);
            $table->integer('no_of_ratings')->default(0);
            $table->integer('no_of_reviews')->default(0);
            $table->integer('is_active')->nullable();
            $table->integer('is_doctor')->nullable();
            $table->dateTime('contract_start_date')->nullable();
            $table->dateTime('contract_expiry_date')->nullable();
            $table->integer('visit_duration')->nullable();
            $table->integer('time_before_next_visit')->nullable();
            $table->integer('added_by')->nullable();
            $table->dateTime('last_login_date')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
        // relations
        Schema::table('providers', function (Blueprint $table) {
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
        Schema::table('providers', function (Blueprint $table) {
            $table->dropForeign(['currency_id']);
        });
        Schema::dropIfExists('providers');
    }
}
