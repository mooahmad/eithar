<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamilyMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_parent_id')->nullable();
            $table->string('first_name',255);
            $table->string('last_name',255);
            $table->string('mobile_number')->nullable();
            $table->integer('relation_type')->nullable();
            $table->integer('gender')->default(0);
            $table->string('profile_picture_path',255)->nullable();
            $table->date('birthdate');
            $table->string('national_id')->nullable();
            $table->integer('nationality_id')->nullable();
            $table->integer('is_active')->default(0);
            $table->integer('is_saudi_nationality')->default(1);
            $table->softDeletes();
            $table->unique('mobile_number');
            $table->timestamps();
        });
        // relations
        Schema::table('family_members', function (Blueprint $table) {
            $table->foreign('user_parent_id')
                ->references('id')
                ->on('users')
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
        Schema::table('family_members', function (Blueprint $table) {
            $table->dropForeign(['user_parent_id']);
        });
        Schema::dropIfExists('family_members');
    }
}
