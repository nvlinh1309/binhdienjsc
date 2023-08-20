<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeRelationToPriceCustomerProdManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('price_customer_prod_management', function (Blueprint $table) {
            $table->dropForeign('price_customer_prod_management_product_goods_id_foreign');
            $table->dropColumn('product_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('price_customer_prod_management', function (Blueprint $table) {
            //
        });
    }
}
