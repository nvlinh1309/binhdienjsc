<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderContractNoToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('document')->nullable();
            $table->unsignedBigInteger('storage_id')->nullable();
            $table->foreign('storage_id')->references('id')->on('storages')->onDelete('cascade');
            $table->text('receive_info')->nullable();
            $table->text('receive_cont')->nullable();
            $table->date('delivery_date')->nullable();
            $table->unsignedBigInteger('receive_user')->nullable();
            $table->foreign('receive_user')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('wh_user')->nullable();
            $table->foreign('wh_user')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('sales_user')->nullable();
            $table->foreign('sales_user')->references('id')->on('users')->onDelete('cascade');
            $table->integer('order_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
