<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollStudiesTable
 * @brief Crear tabla estudios
 *
 * Gestiona la creación o eliminación de la tabla estudios
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePayrollStudiesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_studies', function (Blueprint $table) {
            $table->id();
            $table->string('university_name', 200)->comment('Nombre de la universidad');
            $table->year('graduation_year');
            $table->foreignId('payroll_study_type_id')
                  ->comment('Identificador del tipo de estudio')->constrained()
                  ->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('profession_id')
                  ->comment('Identificador de la profesión')->constrained()
                  ->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('payroll_professional_id')
                  ->comment('Identificador del dato profesional')->constrained()
                  ->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_studies');
    }
}
