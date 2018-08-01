<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name',100);
            $table->string('middle_name',100)->nullable();
            $table->string('last_name',100);
            $table->string('email')->nullable();
            $table->string('email_code', 8)->nullable();
            $table->integer('email_verified')->default(0);
            $table->string('mobile_number')->nullable();
            $table->string('mobile_code', 8)->nullable();
            $table->integer('mobile_verified')->default(0);
            $table->string('password',255);
            $table->string('forget_password_code', 8)->nullable();
            $table->integer('user_type')->nullable();
            $table->integer('gender')->default(0);
            $table->integer('default_language')->nullable();
            $table->string('profile_picture_path',255)->nullable();
            $table->string('nationality_id_picture',255)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('national_id')->nullable();
            $table->integer('nationality_id')->nullable();
            $table->integer('is_active')->default(0);
            $table->integer('is_saudi_nationality')->default(1);
            $table->longText('about')->nullable();
            $table->rememberToken();
            $table->dateTime('last_login_date')->nullable();
            $table->unique('email', 'mobile_number');
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
        Schema::dropIfExists('users');
    }
}
