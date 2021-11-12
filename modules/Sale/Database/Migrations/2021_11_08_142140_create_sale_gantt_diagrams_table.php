<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleGanttDiagramsTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreateSaleGanttDiagramsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sale_gantt_diagrams')) {
            Schema::create('sale_gantt_diagrams', function (Blueprint $table) {
                $table->id();

                $table->string('activity')->nullable()->comment('Actividad del diagrama de gantt');
                $table->text('description')->nullable()->comment('Descripción del diagrama de gantt');
                $table->date('start_date')->nullable()->comment('Fecha de inicio');
                $table->date('end_date')->nullable()->comment('Fecha de fin');
                $table->decimal('percentage')->nullable()->comment('Porcentaje');
                $table->foreignId('payroll_staff_id')->nullable()
                      ->comment('Trabajador')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
                $table->foreignId('sale_technical_proposal_id')->nullable()
                      ->comment('Propuesta técnica')->constrained()
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
        Schema::dropIfExists('sale_gantt_diagrams');
    }
}
