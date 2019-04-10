<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForeignToWarehouseRequestProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_request_products', function (Blueprint $table) {
            if (Schema::hasColumn('warehouse_request_products', 'product_id')) {
                $table->dropColumn('product_id');
            }
            if (Schema::hasColumn('warehouse_request_products', 'unit_id')) {
                $table->dropColumn('unit_id');
            }
            if (Schema::hasColumn('warehouse_request_products', 'warehouse_id')) {
                $table->dropColumn('warehouse_id');
            }
            if (!Schema::hasColumn('warehouse_request_products', 'warehouse_request_id')) {
                $table->integer('warehouse_request_id')->nullable()->comment('Identificador único de la solicitud en la tabla de solicitudes');
                $table->foreign('warehouse_request_id')->references('id')->on('warehouse_requests')->onDelete('restrict')->onUpdate('cascade');
            }
            if (!Schema::hasColumn('warehouse_request_products', 'warehouse_inventary_product_id')) {
                $table->integer('warehouse_inventary_product_id')->nullable()->comment('Identificador único del producto solicitado en la tabla de inventario');
                $table->foreign('warehouse_inventary_product_id')->references('id')->on('warehouse_inventary_products')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::table('warehouse_request_products', function (Blueprint $table) {

        });
    }
}
