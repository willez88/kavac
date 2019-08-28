<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldInventaryProductInitIdToWarehouseInventaryProductMovementsTable
 * @brief Agregar las llaves foráneas de la tabla intermedia de productos-movimientos
 *
 * Gestiona la agregación de llaves foráneas de la tabla intermedia de productos-movimientos
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldInventaryProductInitIdToWarehouseInventaryProductMovementsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_inventary_product_movements', function (Blueprint $table) {
            if (!Schema::hasColumn('warehouse_inventary_product_movements', 'inventary_product_init_id')) {
                $table->integer('inventary_product_init_id')->nullable()
                      ->comment('Identificador único del registro del inventario inicial de los productos movilizados');
                $table->foreign('inventary_product_init_id')->references('id')->on('warehouse_inventary_products')
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
        Schema::table('warehouse_inventary_product_movements', function (Blueprint $table) {
        });
    }
}
