<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldsToPayrollSalaryTabulatorsTable
 * @brief Agrega nuevos campos a la tabla de asignaciones salariales
 *
 * Gestiona la creación o eliminación de nuevos campos de la tabla de asignaciones salariales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldsToPayrollSalaryAssignmentsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('payroll_salary_assignments')) {
            Schema::table('payroll_salary_assignments', function (Blueprint $table) {
                if (!Schema::hasColumn('payroll_salary_assignments', 'institution_id')) {
                    $table->integer('institution_id')->unsigned()->nullable()
                          ->comment('Identificador único de la institución asociada al tabulador');
                    $table->foreign('institution_id')
                          ->references('id')->on('institutions')
                          ->onDelete('restrict')->onUpdate('cascade');
                }

                if (!Schema::hasColumn('payroll_salary_assignments', 'currency_id')) {
                    $table->integer('currency_id')->unsigned()->nullable()
                          ->comment('Identificador único de la moneda asociada al tabulador');
                    $table->foreign('currency_id')
                          ->references('id')->on('currencies')
                          ->onDelete('restrict')->onUpdate('cascade');
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
        Schema::table('payroll_salary_assignments', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_salary_assignments', 'institution_id')) {
                $table->dropForeign(['institution_id']);
                $table->dropColumn('institution_id');
            }

            if (Schema::hasColumn('payroll_salary_assignments', 'currency_id')) {
                $table->dropForeign(['currency_id']);
                $table->dropColumn('currency_id');
            }
        });
    }
}
