<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollSalaryAssignmentTable
 * @brief Crear tabla de asignaciones de nómina
 *
 * Gestiona la creación o eliminación de la tabla de asignaciones de nómina
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreatePayrollSalaryAssignmentsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_salary_assignments')) {
            Schema::create('payroll_salary_assignments', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');
                $table->string('name')->comment('Nombre del tipo de asignación de nómina');
                $table->string('description')->nullable()->comment('Descripción del tipo de asignación de nómina');
                $table->boolean('active')->default(true)->comment('Indica si la asignación esta activa');

                $table->enum('incidence_type', ['absolute_value', 'tax_unit', 'percent'])
                      ->comment('Tipo de incidencia de la asignación, valor absoluto, unidad tributaria o porcentaje');

                $table->bigInteger('payroll_position_type_id')->unsigned()->nullable()
                  ->comment('Identificador único del tipo de cargo al que se aplica la asignación salarial');
                $table->foreign('payroll_position_type_id')->references('id')->on('payroll_position_types')
                  ->onDelete('restrict')->onUpdate('cascade');

                $table->bigInteger('payroll_salary_assignment_type_id')->unsigned()->nullable()
                  ->comment('Identificador único del tipo de asignación salarial');
                $table->foreign('payroll_salary_assignment_type_id')->references('id')
                      ->on('payroll_salary_assignment_types')->onDelete('restrict')->onUpdate('cascade');

                $table->bigInteger('payroll_salary_scale_id')->unsigned()->nullable()
                  ->comment('Identificador único del escalafón asociado a la asignación salarial');
                $table->foreign('payroll_salary_scale_id')->references('id')->on('payroll_salary_assignment_types')
                  ->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('payroll_salary_assignments');
    }
}
