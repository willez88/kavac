<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollAcknowledgmentFilesTable
 * @brief Crear tabla archivos de reconocimiento
 *
 * Gestiona la creación o eliminación de la tabla archivos de reconocimientos
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePayrollAcknowledgmentFilesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_acknowledgment_files')) {
            Schema::create('payroll_acknowledgment_files', function (Blueprint $table) {
                $table->id();
                $table->string('name', 200)->comment('Nombre del reconocimiento');
                $table->foreignId('payroll_acknowledgment_id')
                      ->comment('Identificador del reconocimiento')->constrained()
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
        Schema::dropIfExists('payroll_acknowledgment_files');
    }
}
