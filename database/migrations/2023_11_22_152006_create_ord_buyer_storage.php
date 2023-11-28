<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdBuyerStorage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ord_buyer_storage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('ord_buyers')->onDelete('cascade');
            $table->integer('spn_number'); //SPN
            $table->string('code');
            $table->date('input_date');
            $table->string('content')->nullable(); // Thong tin giao nhan
            $table->string('cont')->nullable(); //Xe/Cont
            $table->unsignedBigInteger('warehouse_staff_id'); //Nhân viên kho vận
            $table->foreign('warehouse_staff_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('ord_buyer_storage');
    }
}
