<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldMeasurementUnitIdToWarehouseProductsTable
 * @brief Agrega nuevos campos a la tabla de productos almacenables
 *
 * Gestiona la creación o eliminación de los campos de la tabla de productos almacenables
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldMeasurementUnitIdToWarehouseProductsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('warehouse_products')) {
            Schema::table('warehouse_products', function (Blueprint $table) {
                if (!Schema::hasColumn('warehouse_products', 'measurement_unit_id')) {
                    $table->bigInteger('measurement_unit_id')->unsigned()->nullable()
                          ->comment('Identificador único de la unidad de medida del producto');
                    $table->foreign('measurement_unit_id')
                          ->references('id')->on('measurement_units')
                          ->onDelete('restrict')->onUpdate('cascade');
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
        if (Schema::hasTable('warehouse_products')) {
            Schema::table('warehouse_products', function (Blueprint $table) {
                if (Schema::hasColumn('warehouse_products', 'measurement_unit_id')) {
                    $table->dropForeign(['measurement_unit_id']);
                    $table->dropColumn(['measurement_unit_id']);
                };
            });
        };
    }
}
