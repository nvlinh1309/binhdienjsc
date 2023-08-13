<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityMinsToStorageProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('storage_product', function (Blueprint $table) {
            $table->renameColumn('quantity', 'quantity_plus');
            $table->integer('quantity_mins')->default(0);
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
