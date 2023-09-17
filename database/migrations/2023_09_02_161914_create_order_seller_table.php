<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderSellerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_seller', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('to_deliver_code');
            $table->string('to_deliver_date');
            $table->unsignedBigInteger('storage_id')->nullable();
            $table->foreign('storage_id')->references('id')->on('storages')->onDelete('cascade');
            $table->string('to_deliver_info')->nullable();
            $table->string('to_deliver_transport')->nullable();
            $table->json('products')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('assignee');
            $table->foreign('assignee')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('order_approver');
            $table->foreign('order_approver')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('warehouse_keeper');
            $table->foreign('warehouse_keeper')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('order_seller');
    }
}
