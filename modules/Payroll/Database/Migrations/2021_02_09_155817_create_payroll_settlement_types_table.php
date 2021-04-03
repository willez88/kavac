<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollSettlementTypesTable
 * @brief Crear tabla tipos de liquidación
 *
 * Gestiona la creación o eliminación de la tabla tipos de liquidación
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePayrollSettlementTypesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_settlement_types')) {
            Schema::create('payroll_settlement_types', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100)->unique()->comment('Nombre del tipo de liquidación');
                $table->text('motive')->comment('Motivo de egreso al que se asocia el tipo de liquidación');
                $table->foreignId('payroll_concept_id')->comment('Identificador del concepto')
                      ->constrained()->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('payroll_settlement_types');
    }
}
