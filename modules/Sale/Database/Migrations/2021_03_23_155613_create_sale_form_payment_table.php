<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleFormPaymentTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreateSaleFormPaymentTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_form_payments', function (Blueprint $table) {
            $table->id();
            $table->string('name_form_payment', 200)->nullable()->comment('Nombre de la forma de pago');
            $table->string('description_form_payment', 200)->comment('Descripción de la forma de pago');
            $table->json('attributes_form_payment')->nullable()->comment('Atributos de la forma de pago');

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
        Schema::dropIfExists('sale_form_payments');
    }
}
