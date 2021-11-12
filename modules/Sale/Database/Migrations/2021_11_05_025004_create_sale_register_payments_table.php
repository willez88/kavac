<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleRegisterPaymentsTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreateSaleRegisterPaymentsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_register_payments', function (Blueprint $table) {
            $table->id();
        $table->boolean('order_or_service_define_attributes')->default(false)->comment('Establecer pedido o servicio. (true) pedido, (false) servicio');
        $table->integer('order_service_id')->unsigned()->nullable()->comment('Id de Pedido o Servicio');
        $table->string('total_amount', 100)->nullable()->comment('Monto total a pagar');
        $table->string('way_to_pay', 100)->nullable()->comment('Forma de pago');
        $table->string('banking_entity', 100)->nullable()->comment('Entidad bancaria');
        $table->integer('reference_number')->unsigned()->nullable()->comment('Número de referencia de la operación');
        $table->date('payment_date')->comment('Fecha de pago');
        $table->boolean('advance_define_attributes')->default(false)->comment('Establecer pago corresponde a un anticipo. (true) si, (false) no');
        $table->boolean('payment_approve')->default(false)->comment('Establecer pago aprobados. (true) si, (false) no');
        $table->boolean('payment_refuse')->default(false)->comment('Establecer pago rechazado. (true) si, (false) no');

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
        Schema::dropIfExists('sale_register_payments');
    }
}
