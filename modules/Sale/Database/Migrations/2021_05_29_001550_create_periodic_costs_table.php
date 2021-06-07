<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePeriodicCostsTable
 * @brief Agrega la tabla para la gestión de la información de costos fijos
 *
 * Agrega la tabla para la gestión de la información de costos fijos
 *
 * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePeriodicCostsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodic_costs', function (Blueprint $table) {
            $table
                ->bigIncrements('id');
            $table
                ->string('name', 60)
                ->nullable()
                ->comment('Nombre');
            $table
                ->text('description')
                ->nullable()
                ->comment('Descripción');
            $table
                ->decimal('value', 13, 2)
                ->nullable()
                ->comment('Valor del costo');
            $table
                ->foreignId('currency_id')
                ->nullable()
                ->constrained()
                ->onDelete('restrict')
                ->onUpdate('cascade')
                ->comment('Id de la moneda (currency)');
            $table
                ->foreignId('frecuency_id')
                ->nullable()
                ->constrained()
                ->onDelete('restrict')
                ->onUpdate('cascade')
                ->comment('Id de la frecuencia de cobro (Frecuency)');
            $table
                ->boolean('attributes')
                ->default(false)
                ->comment('Establecer atributos personalizados. (true) si, (false) no');
            
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
        Schema::dropIfExists('periodic_costs');
    }
}
