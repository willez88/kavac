<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleGoodsToBeTradedsTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreateSaleGoodsToBeTradedsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_goods_to_be_tradeds', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->comment('Nombre');
            $table->string('description', 500)->comment('descripción');
            $table->integer('unit_price', 500)->comment('Precio Unitario');
            $table->integer('coin', 500)->comment('Moneda');
            $table->integer('coin', 500)->comment('Moneda');
            $table->float('iva')


            

            //Unit price Precio Unitario
            //Coin Moneda
            //IVA IVA
            //Unit of measurement Unidad de Medida
            //Units and dependencies in charge    Unidades y dependencias a cargo

            //OJO SI TH NO ESTA INSTALADO
            //list of workers  lista de trabajadores
            //Name, Surname, Telephone and Email    Nombre, Apellido, Teléfono y Correo electrónico

            $table->string('custom_attribute', 500)->comment('Atributo Personalizado');
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
        Schema::dropIfExists('sale_goods_to_be_tradeds');
    }
}
