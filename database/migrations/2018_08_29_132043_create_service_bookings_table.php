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
            $table->integer('is_locked')->default(1);
            $table->integer('unlock_request')->default(0);
            $table->unsignedInteger('promo_code_id')->nullable();
            $table->unsignedInteger('currency_id')->nullable();
            $table->unsignedInteger('family_member_id')->nullable();
            $table->integer('is_lap')->default(0);
            $table->double('price')->nullable();
            $table->longText('comment')->nullable();
            $table->longText('address')->nullable();
            $table->integer('status')->nullable();
            $table->longText('status_desc')->nullable();
            $table->longText('admin_comment')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // relations
        Schema::table('service_bookings', function (Blueprint $table) {
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onUpdate('set null')
                ->onDelete('set null');

            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onUpdate('set null')
                ->onDelete('set null');

            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
                ->onUpdate('set null')
                ->onDelete('set null');

            $table->foreign('provider_id_assigned_by_admin')
                ->references('id')
                ->on('providers')
                ->onUpdate('set null')
                ->onDelete('set null');

            $table->foreign('promo_code_id')
                ->references('id')
                ->on('promo_codes')
                ->onUpdate('set null')
                ->onDelete('set null');

            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies')
                ->onUpdate('set null')
                ->onDelete('set null');

            $table->foreign('family_member_id')
                ->references('id')
                ->on('family_members')
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
        Schema::table('service_bookings', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['service_id']);
            $table->dropForeign(['provider_id']);
            $table->dropForeign(['provider_id_assigned_by_admin']);
            $table->dropForeign(['promo_code_id']);
            $table->dropForeign(['currency_id']);
            $table->dropForeign(['family_member_id']);

        });
        Schema::dropIfExists('service_bookings');
    }
}
