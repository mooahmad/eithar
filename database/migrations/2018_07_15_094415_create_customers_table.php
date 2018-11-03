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
            $table->string('eithar_id',100)->nullable();
            $table->string('first_name',100);
            $table->string('middle_name',100)->nullable();
            $table->string('last_name',100);
            $table->string('email')->nullable();
            $table->integer('email_verified')->default(0);
            $table->string('email_code', 8)->nullable();
            $table->string('mobile_number')->nullable();
            $table->integer('mobile_verified')->default(0);
            $table->string('mobile_code', 8)->nullable();
            $table->string('password');
            $table->string('forget_password_code')->nullable();
            $table->integer('registration_source')->nullable();
            $table->string('registration_source_desc',100)->nullable();
            $table->integer('gender')->default(0);
            $table->string('default_language')->default('en')->nullable();
            $table->string('profile_picture_path',255)->nullable();
            $table->string('nationality_id_picture',255)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('national_id')->nullable();
            $table->integer('nationality_id')->nullable();
            $table->integer('is_active')->default(0);
            $table->integer('is_saudi_nationality')->default(1);
            $table->longText('about')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->string('position',255)->nullable();
            $table->longText('address')->nullable();
            $table->integer('added_by')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->dateTime('last_login_date')->nullable();
            $table->unique('email', 'mobile_number');
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
