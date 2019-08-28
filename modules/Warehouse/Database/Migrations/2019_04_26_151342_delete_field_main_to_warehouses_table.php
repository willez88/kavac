<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class DeleteFieldMainToWarehousesTable
 * @brief Elimina el campo principal de la tabla de almacenes
 *
 * Gestiona la eliminación del campo principal de la tabla de almacenes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class DeleteFieldMainToWarehousesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('warehouses', function (Blueprint $table) {
            if (Schema::hasColumn('warehouses', 'main')) {
                $table->dropColumn('main');
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
        Schema::table('', function (Blueprint $table) {
        });
    }
}
