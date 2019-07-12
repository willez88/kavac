<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollSalaryTabulatorTable
 * @brief Crear tabla de tabuladores salariales
 *
 * Gestiona la creación o eliminación de la tabla de tabuladores salariales
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class CreatePayrollSalaryTabulatorsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function up()
    {
        Schema::create('payroll_salary_tabulators', function (Blueprint $table) {
            $table->increments('id')->comment('Identificador único del registro');
            $table->string('name')->comment('Nombre del tabulador salarial');
            $table->text('description')->nullable()->comment('Descripción del tabulador salarial');
            $table->boolean('active')->default(true)->comment('Indica si el tabulador esta activo');

            $table->integer('payroll_position_type_id')->usigned()->nullable()
                  ->comment('Identificador único del tipo de cargo al que se aplica el tabulador salarial');
            $table->foreign('payroll_position_type_id')->references('id')->on('payroll_position_types')
                  ->onDelete('restrict')->onUpdate('cascade');

            $table->integer('payroll_horizontal_salary_scale_id')->unsigned()->nullable()
                  ->comment('Identificador único del escalafón salarial horizontal asociado al tabulador');
            $table->foreign('payroll_horizontal_salary_scale_id')->references('id')->on('payroll_salary_scales')
                  ->onDelete('restrict')->onUpdate('cascade');

            $table->integer('payroll_vertical_salary_scale_id')->unsigned()->nullable()
                  ->comment('Identificador único del escalafón vertical salarial asociado al tabulador');
            $table->foreign('payroll_vertical_salary_scale_id')->references('id')->on('payroll_salary_scales')
                  ->onDelete('restrict')->onUpdate('cascade');

            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
        });
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function down()
    {
        Schema::dropIfExists('payroll_salary_tabulators');
    }
}
