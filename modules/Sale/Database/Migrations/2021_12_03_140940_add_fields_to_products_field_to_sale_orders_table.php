<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToProductsFieldToSaleOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (Schema::hasTable('sale_orders')) {
        Schema::table('sale_orders', function (Blueprint $table) {
          if (!Schema::hasColumn('sale_orders', 'products')) {
            $table->json('products')->nullable()->comment('Lista de productos');
          }
        });
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('sale_orders', function (Blueprint $table) {
        if (Schema::hasColumn('sale_orders', 'products')) {
          $table->dropColumn('products');
        }
      });
    }
}
