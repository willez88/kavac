<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleGanttStagesTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreateSaleGanttDiagramStagesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sale_gantt_diagram_stages')) {
            Schema::create('sale_gantt_diagram_stages', function (Blueprint $table) {
                $table->id();

                $table->string('stage', 50)->nullable()->comment('Étapa del diagrama de gantt');
                $table->text('description')->nullable()->comment('Descripción de la étapa diagrama de gantt');
                $table->foreignId('sale_gantt_diagram_id')->nullable()
                      ->comment('Diagrama de gantt')->constrained()
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
        Schema::dropIfExists('sale_gantt_diagram_stages');
    }
}
