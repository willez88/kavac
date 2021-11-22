<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollCourseFilesTable
 * @brief Crear tabla archivos de curso
 *
 * Gestiona la creación o eliminación de la tabla archivos de curso
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePayrollCourseFilesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_course_files')) {
            Schema::create('payroll_course_files', function (Blueprint $table) {
                $table->id();
                $table->string('name', 200)->comment('Nombre del curso');
                $table->foreignId('payroll_course_id')
                      ->comment('Identificador del curso')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
                $table->foreignId('image_id')->nullable()
                      ->comment('Identificador de la imagen')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_course_files');
    }
}
