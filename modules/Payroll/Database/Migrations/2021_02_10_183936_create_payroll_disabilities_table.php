<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollDisabilitiesTable
 * @brief Crear tabla discapacidades
 *
 * Gestiona la creación o eliminación de la tabla discapacidades
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePayrollDisabilitiesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_disabilities')) {
            Schema::create('payroll_disabilities', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100)->unique()->comment('Nombre de la discapacidad');
                $table->string('description', 200)->nullable()->comment('Descripción de la discapacidad');
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
        Schema::dropIfExists('payroll_disabilities');
    }
}
