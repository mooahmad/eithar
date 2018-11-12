<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->integer('service_provider_id');
            $table->integer('type')->nullable();
            $table->integer('transaction_type')->nullable();
            $table->longText('transaction_description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // relations
        Schema::table('transactions_users', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('customers')
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
        Schema::table('transactions_users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('transactions_users');
    }
}
