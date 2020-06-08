<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollProfessionalsTable
 * @brief Crear tabla profesional del trabajador
 *
 * Gestiona la creación o eliminación de la tabla profesional del trabajador
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreatePayrollProfessionalsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_professionals')) {
            Schema::create('payroll_professionals', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('instruction_degree_name', 100)
                      ->nullable()
                      ->comment(
                          'Nombre en caso de elegir en Grado de Instrucción: Especialización, Maestría, Doctorado'
                      );
                $table->text('study_program_name')->nullable()->comment('Nombre del programa de estudio');
                $table->text('class_schedule')->nullable()->comment('Horario de clase');
                $table->boolean('is_student')->default(false)->comment('Establece si el trabajdor es estudiante o no');

                $table->bigInteger('payroll_staff_id')->unsigned()->unique()
                      ->comment('identificador del trabajador que pertenece a la información profesional');
                $table->foreign('payroll_staff_id')->references('id')->on('payroll_staffs')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->bigInteger('payroll_instruction_degree_id')->unsigned()
                      ->comment('identificador del grado de instrucción que pertenece a la información profesional');
                $table->foreign('payroll_instruction_degree_id')->references('id')->on('payroll_instruction_degrees')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->bigInteger('payroll_study_type_id')->unsigned()->nullable()
                      ->comment('identificador del tipo de estudio que pertenecen a la información profesional');
                $table->foreign('payroll_study_type_id')->references('id')->on('payroll_study_types')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_professionals');
    }
}
