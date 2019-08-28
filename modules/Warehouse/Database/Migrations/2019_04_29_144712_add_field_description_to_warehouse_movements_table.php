<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldDescriptionToWarehouseMovementsTable
 * @brief Agregar el campo descripción en la tabla de movimientos de almacén
 *
 * Gestiona la agregación del campo descripción en la tabla de movimientos de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldDescriptionToWarehouseMovementsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_movements', function (Blueprint $table) {
            if (Schema::hasColumn('warehouse_movements', 'motive')) {
                $table->dropColumn('motive');
            }

            if (!Schema::hasColumn('warehouse_movements', 'description')) {
                $table->string('description')->nullable()
                      ->comment('Motivo o descripcion del movimiento de almacen');
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
        Schema::table('warehouse_movements', function (Blueprint $table) {
        });
    }
}
