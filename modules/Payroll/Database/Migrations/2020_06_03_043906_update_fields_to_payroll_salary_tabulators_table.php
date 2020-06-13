<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      UpdateFieldsToPayrollSalaryTabulatorsTable
 * @brief      Actualiza los campos de la tabla de tabuladores salariales
 *
 * Gestiona la creación o eliminación de los campos de la tabla de tabuladores salariales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class UpdateFieldsToPayrollSalaryTabulatorsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (Schema::hasTable('payroll_salary_tabulators')) {
            Schema::table('payroll_salary_tabulators', function (Blueprint $table) {
                if (Schema::hasColumn('payroll_salary_tabulators', 'code')) {
                    $table->string('code', 20)->nullable()
                          ->comment('Código asociado al tabulador')->change();
                }
                if (!Schema::hasColumn('payroll_salary_tabulators', 'payroll_salary_tabulator_type')) {
                    $table->string('payroll_salary_tabulator_type')->nullable()
                          ->comment('Tipo de tabulador salarial');
                }
                if (Schema::hasColumn('payroll_salary_tabulators', 'payroll_staff_type_id')) {
                    $table->dropForeign(['payroll_staff_type_id']);
                    $table->dropColumn('payroll_staff_type_id');
                }
            });
        };
    }

    /**
     * Método que elimina las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function down()
    {
        Schema::table('payroll_salary_tabulators', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_salary_tabulators', 'code')) {
                    $table->string('code')->nullable()
                          ->comment('Código asociado al tabulador')->change();
            }
            if (Schema::hasColumn('payroll_salary_tabulators', 'payroll_salary_tabulator_type')) {
                $table->dropColumn('payroll_salary_tabulator_type');
            }
            if (!Schema::hasColumn('payroll_salary_tabulators', 'payroll_staff_type_id')) {
                $table->bigInteger('payroll_staff_type_id')->unsigned()->nullable()
                      ->comment('Identificador único del tipo de personal al que se aplica el tabulador salarial');
                $table->foreign('payroll_staff_type_id')->references('id')->on('payroll_staff_types')
                      ->onDelete('restrict')->onUpdate('cascade');
            }
        });
    }
}
