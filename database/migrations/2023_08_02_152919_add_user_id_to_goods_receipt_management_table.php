<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToGoodsReceiptManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goods_receipt_management', function (Blueprint $table) {
            $table->unsignedBigInteger('approval_user')->nullable();
            $table->foreign('approval_user')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('receive_user')->nullable();
            $table->foreign('receive_user')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('wh_user')->nullable();
            $table->foreign('wh_user')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('sales_user')->nullable();
            $table->foreign('sales_user')->references('id')->on('users')->onDelete('cascade');
            $table->integer('receipt_status')->nullable();
            $table->text('receive_info')->nullable();
            $table->text('receive_cont')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goods_receipt_management', function (Blueprint $table) {
            //
        });
    }
}
