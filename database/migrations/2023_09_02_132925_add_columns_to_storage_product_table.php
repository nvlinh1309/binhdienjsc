<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToStorageProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('storage_product', function (Blueprint $table) {
            $table->integer('in_stock');
            $table->integer('sold');
            $table->unsignedBigInteger('order_buyer_id');
            $table->foreign('order_buyer_id')->references('id')->on('order_buyer')->onDelete('cascade');
            $table->json('product_info');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('storage_product', function (Blueprint $table) {
            //
        });
    }
}
