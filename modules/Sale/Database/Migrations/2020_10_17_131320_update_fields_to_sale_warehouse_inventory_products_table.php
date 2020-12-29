<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldsToSaleWarehouseInventoryProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_warehouse_inventory_products', function (Blueprint $table) {
            if (Schema::hasColumn('sale_warehouse_inventory_products', 'sale_setting_products_id')) {
                $table->dropForeign('sale_warehouse_inventory_products_setting_fk');
                $table->dropColumn(['sale_setting_products_id']);
            }
            if (!Schema::hasColumn('sale_warehouse_inventory_products', 'sale_setting_product_id')) {
                $table->unsignedBigInteger('sale_setting_product_id');
                $table->foreign('sale_setting_product_id', 'sale_warehouse_inventory_products_settings_id_fk')
                      ->references('id')->on('sale_setting_products')
                      ->onDelete('restrict')->onUpdate('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_warehouse_inventory_products', function (Blueprint $table) {
            if (!Schema::hasColumn('sale_warehouse_inventory_products', 'sale_setting_product_id')) {
                $table->foreignId('sale_setting_product_id')->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');
            }
        });
    }
}
