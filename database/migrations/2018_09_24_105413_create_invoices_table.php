<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id')->nullable();
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onUpdate('set null')
                ->onDelete('set null');

            $table->unsignedInteger('provider_id')->nullable();
            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
                ->onUpdate('set null')
                ->onDelete('set null');

            $table->unsignedInteger('service_booking_id')->nullable();
            $table->foreign('service_booking_id')
                ->references('id')
                ->on('service_bookings')
                ->onUpdate('set null')
                ->onDelete('set null');

            $table->unsignedInteger('currency_id')->nullable();
            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies')
                ->onUpdate('set null')
                ->onDelete('set null');

            $table->double('amount_original')->default(0)->nullable();
            $table->double('amount_after_discount')->default(0)->nullable();
            $table->double('amount_after_vat')->default(0)->nullable();
            $table->double('amount_final')->default(0)->nullable();

            $table->integer('is_saudi_nationality')->default(1)->nullable();

            $table->timestamp('invoice_date')->useCurrent()->nullable();
            $table->string('invoice_code')->nullable();

            $table->string('pdf_path')->nullable();

            $table->integer('is_paid')->default(0)->nullable();
            $table->integer('payment_method')->nullable();
            $table->string('payment_transaction_number')->nullable();

            $table->text('provider_comment')->nullable();
            $table->text('admin_comment')->nullable();

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
        Schema::dropIfExists('invoices');
    }
}
