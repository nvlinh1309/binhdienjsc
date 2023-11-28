<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStorageIdToOrdBuyers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ord_buyers', function (Blueprint $table) {
            $table->unsignedBigInteger('storage_id')->after('supplier_id');
            $table->foreign('storage_id')->references('id')->on('storages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ord_buyers', function (Blueprint $table) {
            //
        });
    }
}
