<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleQuote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_quote_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_enterprise', 200)->nullable()->comment('Name de la empresa');
            $table->string('address_applicant', 200)->comment('Dirección del solicitante');
            $table->string('name_applicant', 100)->comment('Nombre del solicitante');
            $table->string('email_applicant')->unique()->nullable()->comment('Correo del solicitante');
            $table->string('phone_applicant')->nullable()->comment('Telefono del solicitante');
            $table->string('description_product')->nullable()->comment('Descripcion del producto');
            $table->string('quantity_product')->nullable()->comment('Cantidad del producto');
            $table->string('unit_product')->nullable()->comment('Unidad de medida');
            $table->string('payment_type_product')->nullable()->comment('Tipo de producto');
            $table->string('reply_deadline_product')->nullable()->comment('Fecha límite de respuesta');

            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_quote_products');
    }
}
