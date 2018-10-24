<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('name_en', 255);
            $table->string('name_ar', 255);
            $table->longText('description_en')->nullable();
            $table->longText('description_ar')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('type')->default(1);
            $table->longText('type_description')->nullable();
            $table->string('code', 255)->unique();
            $table->integer('discount_percentage')->default(0);
            $table->longText('comment')->nullable();
            $table->integer('is_approved')->default(0);
            $table->integer('added_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        // relations
        Schema::table('promo_codes', function (Blueprint $table) {
            $table->foreign('user_id')
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
        Schema::table('promo_codes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('promo_codes');
    }
}
