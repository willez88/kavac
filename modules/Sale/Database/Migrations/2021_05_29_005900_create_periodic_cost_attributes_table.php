<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePeriodicCostAttributesTable
 * @brief Agrega la tabla para la gestión de atributos de los costos fijos
 *
 * Agrega la tabla para la gestión de atributos de los costos fijos
 *
 * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePeriodicCostAttributesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodic_cost_attributes', function (Blueprint $table) {
            $table->id();
            $table
                ->string('name', 100)->nullable()
                ->comment('Nombre o descripción del atributo o característica específica del tipo de bien');

            $table
                ->foreignId('periodic_cost_id')
                ->constrained()
                ->onDelete('restrict')
                ->onUpdate('cascade');
            
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
        Schema::dropIfExists('periodic_cost_attributes');
    }
}
