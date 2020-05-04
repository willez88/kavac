<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleSettingProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_setting_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sale_setting_product_type_id')->unsigned()
                  ->comment('Tipo de producto');
            $table->foreign('sale_setting_product_type_id')->references('id')->on('sale_setting_product_types')
                  ->onDelete('restrict')->onUpdate('cascade');
            $table->string('name')->comment('Nombre');
            $table->string('code')->comment('Código');
            $table->string('description')->comment('Descripción');
            $table->string('price')->comment('Precio unitario');
            $table->string('iva')->unsigned()->nullable()
                  ->comment('IVA');

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
        Schema::dropIfExists('sale_setting_products');
    }
}
