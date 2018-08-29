<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('service_id')->nullable();
            $table->unsignedInteger('provider_id')->nullable();
            $table->unsignedInteger('provider_id_assigned_by_admin')->nullable();
            $table->unsignedInteger('promo_code_id')->nullable();
            $table->unsignedInteger('currency_id')->nullable();
            $table->unsignedInteger('family_member_id')->nullable();
            $table->integer('is_lap')->default(0);
            $table->double('price')->nullable();
            $table->dateTime('appointment_date_time')->nullable();
            $table->longText('comment')->nullable();
            $table->longText('address')->nullable();
            $table->integer('status')->nullable();
            $table->longText('status_desc')->nullable();
            $table->longText('admin_comment')->nullable();
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
        Schema::dropIfExists('service_bookings');
    }
}
