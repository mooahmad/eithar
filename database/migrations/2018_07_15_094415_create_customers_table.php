<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->integer('email_verified')->default(0);
            $table->string('mobile_number')->unique();
            $table->integer('mobile_verified')->default(0);
            $table->string('password');
            $table->integer('registration_source')->nullable();
            $table->string('registration_source_desc')->nullable();
            $table->integer('gender')->default(0);
            $table->integer('default_language')->nullable();
            $table->string('profile_picture_path')->nullable();
            $table->date('birthdate');
            $table->string('national_id')->nullable();
            $table->integer('nationality_id')->nullable();
            $table->integer('is_active')->default(0);
            $table->integer('is_saudi_nationality')->default(1);
            $table->longText('about')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->dateTime('last_login_date')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
