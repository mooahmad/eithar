<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id')->nullable();
            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices')
                ->onUpdate('set null')
                ->onDelete('set null');

            $table->unsignedInteger('service_id')->nullable();
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onUpdate('set null')
                ->onDelete('set null');

            $table->unsignedInteger('provider_id')->nullable();
            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
                ->onUpdate('set null')
                ->onDelete('set null');

            $table->integer('status')->default(1)->nullable();
            $table->double('price')->default(0)->nullable();

            $table->string('item_desc_appear_in_invoice')->nullable();

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
        Schema::dropIfExists('invoice_items');
    }
}
