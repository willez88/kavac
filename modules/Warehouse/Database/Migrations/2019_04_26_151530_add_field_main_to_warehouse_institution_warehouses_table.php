<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldMainToWarehouseInstitutionWarehousesTable
 * @brief Agregar el campo principal en la tabla intermedia de institucion-almacén
 *
 * Gestiona la agregación del campo principal en la tabla intermedia de institucion-almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldMainToWarehouseInstitutionWarehousesTable extends Migration
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
            if (!Schema::hasColumn('warehouse_institution_warehouses', 'main')) {
                $table->boolean('main')->default(false)
                      ->comment('Define si es el almacen principal');
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
        Schema::table('warehouse_institution_warehouses', function (Blueprint $table) {
        });
    }
}
