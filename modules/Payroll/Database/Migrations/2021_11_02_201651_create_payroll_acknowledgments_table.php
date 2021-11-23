<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollAcknowledgmentsTable
 * @brief Crear tabla reconocimientos
 *
 * Gestiona la creación o eliminación de la tabla reconocimientos
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePayrollAcknowledgmentsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_acknowledgments')) {
            Schema::create('payroll_acknowledgments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('payroll_professional_id')->unique()
                      ->comment('Identificador del dato profesional')->constrained()
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
        Schema::dropIfExists('payroll_acknowledgments');
    }
}
