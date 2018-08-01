<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_parent_id')->nullable();
            $table->string('category_name_ar', 255);
            $table->string('category_name_en', 255);
            $table->longText('description_ar')->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('profile_picture_path')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        // relations
        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('category_parent_id')
                  ->references('id')
                  ->on('categories')
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
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['category_parent_id']);
        });
        Schema::dropIfExists('category');
    }
}
