<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollProfessionalInformationsTable
 * @brief Crear tabla de la información profesional del trabajador
 *
 * Gestiona la creación o eliminación de la tabla de información profesional del trabajador
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreatePayrollProfessionalInformationsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
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


                $table->foreignId('profession_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->string('instruction_degree_name', 100)->nullable()->comment(
                    'Nombre en caso de elegir en Grado de Instrucción: Especialización, Maestría, Doctorado'
                );

                $table->boolean('is_student')->default(false)->comment(
                    'Establece si el trabajdor es estudiante o no'
                );

                $table->foreignId('payroll_study_type_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->text('study_program_name')->nullable()->comment('Nombre del programa de estudio');
                $table->text('class_schedule')->nullable()->comment('Descripción de la cuenta');

                $table->foreignId('payroll_language_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->unsignedBigInteger('payroll_language_level_id')->comment(
                    'identificador de nivel del idioma que pertenece a la información profesional'
                );
                $table->foreign(
                    'payroll_language_level_id',
                    'payroll_professional_informations_language_level_pk'
                )->references('id')->on('payroll_language_levels')->onDelete('restrict')->onUpdate('cascade');


                $table->foreignId('payroll_staff_id')->unique()->constrained()
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
        Schema::dropIfExists('payroll_professional_informations');
    }
}
