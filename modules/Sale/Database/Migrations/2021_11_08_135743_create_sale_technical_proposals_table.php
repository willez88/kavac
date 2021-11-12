<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleTechnicalProposalsTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreateSaleTechnicalProposalsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sale_technical_proposals')) {
            Schema::create('sale_technical_proposals', function (Blueprint $table) {
                $table->id();

                $table->string('duration')->nullable()->comment('Duración de la propuesta técnica');
                $table->foreignId('frecuency_id')->nullable()
                      ->comment('Unidad de tiempo')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
                $table->foreignId('sale_service_id')->nullable()
                      ->comment('Solicitud de servicio')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
                $table->text('sale_list_subservices')->nullable()->comment('Lista de subservicios');
                $table->text('payroll_staffs')->nullable()->comment('Trabajadores');
                $table->text('asset_asignations')->nullable()->comment('Bienes asignados');

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
        Schema::dropIfExists('sale_technical_proposals');
    }
}
