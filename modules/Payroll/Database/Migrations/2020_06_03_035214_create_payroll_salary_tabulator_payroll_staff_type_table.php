<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      CreatePayrollSalaryTabulatorPayrollStaffTypeTable
 * @brief      Crear tabla intermedia entre tabuladores salariales y tipo de personal
 *
 * Gestiona la creación o eliminación de la tabla intermedia entre tabuladores salariales y tipo de personal
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class CreatePayrollSalaryTabulatorPayrollStaffTypeTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_salary_tabulator_payroll_staff_type')) {
            Schema::create('payroll_salary_tabulator_payroll_staff_type', function (Blueprint $table) {
                $table->id()->comment('Identificador único del registro');

                $table->bigInteger('payroll_staff_type_id')->unsigned()->nullable()
                      ->comment('Identificador único del tipo de personal asociado al registro');
                $table->foreign(
                    'payroll_staff_type_id',
                    'payroll_salary_tabulator_staff_type_staff_type_fk')
                      ->references('id')->on('payroll_staff_types')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->bigInteger('payroll_salary_tabulator_id')->unsigned()->nullable()
                      ->comment('Identificador único del tabulador asociado al registro');
                $table->foreign(
                    'payroll_salary_tabulator_id',
                    'payroll_salary_tabulator_staff_type_salary_tabulator_fk')
                      ->references('id')->on('payroll_salary_tabulators')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
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
        Schema::dropIfExists('payroll_salary_tabulator_payroll_staff_type');
    }
}
