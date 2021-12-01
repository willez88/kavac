<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductsFieldToSaleOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_orders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->nullable()->comment('Nombre y apellido del solicitante');
            $table->string('email', 200)->comment('Correo electrónico del solicitante');
            $table->string('phone', 200)->comment('Número de teléfono');
            $table->string('description', 200)->comment('Descripción de la actividad económica');
            $table->string('status', 100)->nullable()->comment('Estado de la solicitud')->default('pending');
            $table->json('products')->nullable()->comment('Lista de productos');

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
        Schema::dropIfExists('sale_orders');
    }
}
