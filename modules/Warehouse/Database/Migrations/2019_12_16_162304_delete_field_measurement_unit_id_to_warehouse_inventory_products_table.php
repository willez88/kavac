<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class DeleteFieldMeasurementUnitIdToWarehouseInventoryProductsTable
 * @brief Agrega nuevos campos a la tabla de inventario de productos de almacén
 *
 * Gestiona la creación o eliminación de los campos de la tabla de inventario de productos de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class DeleteFieldMeasurementUnitIdToWarehouseInventoryProductsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('warehouse_inventory_products')) {
            Schema::table('warehouse_inventory_products', function (Blueprint $table) {
                if (Schema::hasColumn('warehouse_inventory_products', 'measurement_unit_id')) {
                    $table->dropForeign(['measurement_unit_id']);
                    $table->dropColumn(['measurement_unit_id']);
                };
            });
        };
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('warehouse_inventory_products')) {
            Schema::table('warehouse_inventory_products', function (Blueprint $table) {
                if (!Schema::hasColumn('warehouse_inventory_products', 'measurement_unit_id')) {
                    $table->foreignId('measurement_unit_id')->nullable()->constrained()
                          ->onDelete('restrict')->onUpdate('cascade');
                };
            });
        };
    }
}
