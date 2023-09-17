<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagingStorageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packaging_storage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('storage_id')->nullable(); // mã kho hàng
            $table->foreign('storage_id')->references('id')->on('storages')->onDelete('cascade');
            $table->unsignedBigInteger('packaging_id')->nullable(); // mã bao bì
            $table->foreign('packaging_id')->references('id')->on('packaging')->onDelete('cascade');
            $table->integer('quantity');
            $table->string('lot'); // lô hàng
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
        Schema::dropIfExists('packaging_storage');
    }
}
