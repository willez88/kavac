<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldsToPayrollSalaryScalesTable
 * @brief Agrega el campo tipo a la tabla de escalafones salariales
 *
 * Gestiona la creación o eliminación del campo type de la tabla de escalafones salariales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldsToPayrollSalaryScalesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('payroll_salary_scales')) {
            Schema::table('payroll_salary_scales', function (Blueprint $table) {
                if (!Schema::hasColumn('payroll_salary_scales', 'code')) {
                    $table->string('code')->unique()->nullable()
                          ->comment('Código del escalafón');
                }
                if (!Schema::hasColumn('payroll_salary_scales', 'group_by_years')) {
                    $table->string('group_by_years')->nullable()
                    ->comment('Tipo de agrupación, (antiquity) años se servicio, (experience) años de experiencia');
                }
                if (!Schema::hasColumn('payroll_salary_scales', 'group_by_clasification')) {
                    $table->string('group_by_clasification')->nullable()
                    ->comment('Tipo de agrupación, (position) cargo, (instruction_degree) grado de instrucción');
                }
                if (!Schema::hasColumn('payroll_salary_scales', 'institution_id')) {
                    $table->integer('institution_id')->unsigned()->nullable()
                          ->comment('Identificador único de la institución asociada al escalafón');
                    $table->foreign('institution_id')
                          ->references('id')->on('institutions')
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
        Schema::table('payroll_salary_scales', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_salary_scales', 'code')) {
                $table->dropUnique(['code']);
                $table->dropColumn('code');
            }
            if (Schema::hasColumn('payroll_salary_scales', 'group_by_years')) {
                $table->dropColumn('group_by_years');
            }
            if (Schema::hasColumn('payroll_salary_scales', 'group_by_clasification')) {
                $table->dropColumn('group_by_clasification');
            }
            if (Schema::hasColumn('payroll_salary_scales', 'institution_id')) {
                $table->dropForeign(['institution_id']);
                $table->dropColumn('institution_id');
            }
        });
    }
}
