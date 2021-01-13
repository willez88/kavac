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
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
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
                $table->foreignId('payroll_staff_type_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');
            }
        });
    }
}
