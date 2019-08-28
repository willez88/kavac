<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldWarehouseInstitutionIdToWarehouseInventaryProductsTable
 * @brief Agregar las llaves foráneas de la tabla de inventario de productos
 *
 * Gestiona la agregación de las llaves foráneas de la tabla de inventario de productos
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldWarehouseInstitutionIdToWarehouseInventaryProductsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_inventary_products', function (Blueprint $table) {
            if (Schema::hasColumn('warehouse_inventary_products', 'warehouse_id')) {
                $table->dropColumn('warehouse_id');
            }
            if (!Schema::hasColumn('warehouse_inventary_products', 'warehouse_institution_id')) {
                $table->integer('warehouse_institution_id')->nullable()
                      ->comment('Identificador único del producto inventariado en la tabla institución-almacén');
                $table->foreign('warehouse_institution_id')->references('id')->on('warehouse_institution_warehouses')
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
        Schema::table('warehouse_inventary_products', function (Blueprint $table) {
        });
    }
}
