<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleQuoteTable
 * @brief Agrega la tabla para gestionar las cotizaciones
 *
 * Agrega la tabla para gestionar las cotizaciones
 *
 * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreateSaleQuoteTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_quotes', function (Blueprint $table) {
            $table
              ->bigIncrements('id');
            $table
              ->string('name', 100)
              ->comment('nombre de la persona');
            $table
              ->string('id_number', 60)
              ->comment('Documento de Identidad');

            $table
              ->string('email', 60)
              ->comment('Correo electronico');

            $table
              ->string('type_person', 200)
              ->comment('Type of person');

            $table->foreignId('sale_payment_method_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table
              ->date('deadline_date')
              ->comment('Fecha límite de respuesta');

            $table
                ->integer('status')
                ->unsigned()
                ->nullable()
                ->comment('Estatus de la solicitud');

            $table
              ->string('phone', 60)
              ->comment('Telefono');

            $table
                ->decimal('total', 13, 2)
                ->nullable()
                ->comment('Valor total');

            $table
                ->decimal('total_without_tax', 13, 2)
                ->nullable()
                ->comment('Valor total sin impuesto');
            
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
        Schema::dropIfExists('sale_quotes');
    }
}
