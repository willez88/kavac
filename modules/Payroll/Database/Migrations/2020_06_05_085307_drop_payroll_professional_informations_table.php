<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class DropPayrollProfessionalInformationsTable
 * @brief Elimina la tabla payroll_professional_informations
 *
 * Gestiona la creación o eliminación de la tabla
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class DropPayrollProfessionalInformationsTable extends Migration
{
    /**
     * Método que elimina la tabla payroll_professional_informations
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('payroll_professional_informations');
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Método que crea la tabla payroll_professional_informations
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('payroll_professional_informations')) {
            Schema::create('payroll_professional_informations', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('payroll_instruction_degree_id')->comment(
                    'identificador del grado de instrucción que pertenece a la información profesional'
                );
                $table->foreign(
                    'payroll_instruction_degree_id',
                    'payroll_professional_informations_instruction_degree_fk'
                )->references('id')->on('payroll_instruction_degrees')->onDelete('restrict')->onUpdate('cascade');


                $table->string('instruction_degree_name', 100)->nullable()->comment(
                    'Nombre en caso de elegir en Grado de Instrucción: Especialización, Maestría, Doctorado'
                );

                $table->boolean('is_student')->default(false)->comment('Establece si el trabajdor es estudiante o no');

                $table->foreignId('payroll_study_type_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->text('study_program_name')->nullable()->comment('Nombre del programa de estudio');
                $table->text('class_schedule')->nullable()->comment('Descripción de la cuenta');

                $table->foreignId('payroll_staff_id')->unique()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }
}
