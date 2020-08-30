<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BillFieldsInvoiceItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->string('quantity',50)->default(1);
            $table->string('discount_percent',100)->nullable();
            $table->string('tax_percent',50)->nullable();
            $table->string('tax',50)->nullable();
            $table->string('discount',100)->nullable();
        });
    }
}
