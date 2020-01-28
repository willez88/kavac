<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldsToPayrollScaleRequirementsTable
 * @brief Actualiza los campos de la tabla de requerimientos de los escalafones salariales
 *
 * Gestiona la actualización los campos de la tabla de requerimientos de los escalafones salariales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class UpdateFieldsToPayrollScaleRequirementsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('payroll_scale_requirements')) {
            Schema::table('payroll_scale_requirements', function (Blueprint $table) {
                if (Schema::hasColumn('payroll_scale_requirements', 'scale_years_minimum')) {
                    $table->float('scale_years_minimum')->unsigned()->nullable()
                        ->comment('Cantidad minima de años requeridas por la escala')->change();
                }
                if (Schema::hasColumn('payroll_scale_requirements', 'scale_years_maximum')) {
                    $table->float('scale_years_maximum')->unsigned()->nullable()
                        ->comment('Cantidad minima de años requeridas por la escala')->change();
                }
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_scale_requirements', function (Blueprint $table) {
        });
    }
}
