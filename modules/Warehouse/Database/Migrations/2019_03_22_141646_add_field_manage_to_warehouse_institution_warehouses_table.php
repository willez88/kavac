<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldManageToWarehouseInstitutionWarehousesTable
 * @brief Agregar el campo gestionar en la tabla intermedia de instituciones-almacenes
 *
 * Gestiona la agregación del campo gestionar en la tabla intermedia de instituciones-almacenes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldManageToWarehouseInstitutionWarehousesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_institution_warehouses', function (Blueprint $table) {
            $table->boolean('manage')->default(true)
                      ->comment('Estatus de gestión. (true) activo, (false) inactivo');
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
        Schema::table('warehouse_institution_warehouses', function (Blueprint $table) {
            $table->dropColumn('manage');
        });
    }
}
