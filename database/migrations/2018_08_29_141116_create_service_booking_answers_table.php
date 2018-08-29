<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceBookingAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_booking_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('service_booking_id')->nullable();
            $table->unsignedInteger('service_questionnaire_id')->nullable();
            $table->string('answer', 255);
            $table->integer('question_type');
            $table->string('title_ar', 255);
            $table->string('title_en', 255);
            $table->string('subtitle_ar', 255);
            $table->string('subtitle_en', 255);
            $table->integer('type')->nullable();
            $table->string('options_ar', 255);
            $table->string('options_en', 255);
            $table->integer('is_required')->nullable();
            $table->integer('rating_levels')->nullable();
            $table->integer('rating_symbol')->nullable();
            $table->integer('order')->nullable();
            $table->integer('pagination')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // relations
        Schema::table('service_booking_answers', function (Blueprint $table) {
            $table->foreign('service_booking_id')
                ->references('id')
                ->on('service_bookings')
                ->onUpdate('set null')
                ->onDelete('set null');

            $table->foreign('service_questionnaire_id')
                ->references('id')
                ->on('questionnaires')
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
        Schema::table('service_booking_answers', function (Blueprint $table) {
            $table->dropForeign(['service_booking_id']);
            $table->dropForeign(['service_questionnaire_id']);

        });
        Schema::dropIfExists('service_booking_answers');
    }
}
