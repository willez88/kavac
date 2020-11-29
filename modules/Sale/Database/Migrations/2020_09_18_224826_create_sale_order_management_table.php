<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleOrderManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_order_management', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->comment('Nombre o descripción de pedido');
            $table->string('cedule', 100)->comment('Cédula');
            $table->string('type', 100)->comment('Tipo');
            $table->string('code', 100)->comment('Código');
            $table->string('category', 100)->comment('Categoria');
            $table->string('quantity', 100)->comment('Cantidad');
            //$table->string('address', 100)->comment('Dirección');
            //$table->string('contact_number', 100)->comment('Número Teléfonico');

            //$table->string('warehouse', 100)->comment('Almacén');
            //$table->foreignId('sale_warehouses_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('sale_order_management');
    }
}