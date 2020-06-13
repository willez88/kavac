<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollSalaryTabulatorScalesTable
 * @brief Crear tabla de escalas asociados a los tabuladores salariales
 *
 * Gestiona la creación o eliminación de la tabla de escalas asociados a los tabuladores salariales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreatePayrollSalaryTabulatorScalesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_salary_tabulator_scales')) {
            Schema::create('payroll_salary_tabulator_scales', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->unsignedBigInteger('payroll_horizontal_scale_id')->nullable()
                      ->comment('Identificador único de la escala horizontal asociado al registro');
                $table->foreign('payroll_horizontal_scale_id', 'payroll_salary_tabulator_scales_horizontal_scale_fk')
                      ->references('id')->on('payroll_scales')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->unsignedBigInteger('payroll_vertical_scale_id')->nullable()
                      ->comment('Identificador único de la escala vertical asociado al registro');
                $table->foreign('payroll_vertical_scale_id', 'payroll_salary_tabulator_scales_vertical_scale_fk')
                      ->references('id')->on('payroll_scales')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->unsignedBigInteger('payroll_salary_tabulator_id')
                      ->comment('Identificador único del tabulador salarial asociado al registro');
                $table->foreign('payroll_salary_tabulator_id', 'payroll_salary_tabulator_scales_salary_tabulator_fk')
                      ->references('id')->on('payroll_salary_tabulators')
                      ->onDelete('restrict')->onUpdate('cascade');


                $table->float('value')->comment('Valor de la escala asociada al tabulador salarial');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
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
        Schema::dropIfExists('payroll_salary_tabulator_scales');
    }
}
