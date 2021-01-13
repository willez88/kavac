<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      UpdateFieldsToPayrollSalaryScalesTable
 * @brief      Actualiza los campos de la tabla de escalafones salariales
 *
 * Gestiona la creación o eliminación de los campos de la tabla de escalafones salariales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UpdateFieldsToPayrollSalaryScalesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        Schema::table('payroll_salary_scales', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_salary_scales', 'code')) {
                $table->dropUnique(['code']);
                $table->string('code', 20)->unique()->nullable()
                      ->comment('Código identificador del escalafón')->change();
            }
            if (Schema::hasColumn('payroll_salary_scales', 'group_by_years')) {
                $table->dropColumn('group_by_years');
            }
            if (Schema::hasColumn('payroll_salary_scales', 'group_by_clasification')) {
                $table->dropColumn('group_by_clasification');
            }
            if (!Schema::hasColumn('payroll_salary_scales', 'group_by')) {
                $table->string('group_by')->nullable()->comment('Escalas o niveles del escalafón');
            }
        });
    }

    /**
     * Método que elimina las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function down()
    {
        Schema::table('payroll_salary_scales', function (Blueprint $table) {
            if (!Schema::hasColumn('payroll_salary_scales', 'code')) {
                $table->string('code')->unique()->nullable()
                      ->comment('Código del escalafón')->change();
            }
            if (!Schema::hasColumn('payroll_salary_scales', 'group_by_years')) {
                $table->string('group_by_years')->nullable()
                ->comment('Tipo de agrupación, (antiquity) años se servicio, (experience) años de experiencia');
            }
            if (!Schema::hasColumn('payroll_salary_scales', 'group_by_clasification')) {
                $table->string('group_by_clasification')->nullable()
                ->comment('Tipo de agrupación, (position) cargo, (instruction_degree) grado de instrucción');
            }
            if (Schema::hasColumn('payroll_salary_scales', 'group_by')) {
                $table->dropColumn('group_by');
            }
        });
    }
}
