<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldsForeignToWarehouseRequestProductsTable
 * @brief Agregar las llaves foráneas de la tabla intermedia de productos-solicitudes
 *
 * Gestiona la agregación de llaves foráneas de la tabla intermedia de productos-solicitudes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldsForeignToWarehouseRequestProductsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
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
                $table->integer('warehouse_request_id')->nullable()
                      ->comment('Identificador único de la solicitud en la tabla de solicitudes');
                $table->foreign('warehouse_request_id')->references('id')->on('warehouse_requests')
                      ->onDelete('restrict')->onUpdate('cascade');
            }
            if (!Schema::hasColumn('warehouse_request_products', 'warehouse_inventary_product_id')) {
                $table->integer('warehouse_inventary_product_id')->nullable()
                      ->comment('Identificador único del producto solicitado en la tabla de inventario');
                $table->foreign('warehouse_inventary_product_id')->references('id')->on('warehouse_inventary_products')
                      ->onDelete('restrict')->onUpdate('cascade');
            }
        });
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('warehouse_request_products', function (Blueprint $table) {
        });
    }
}
