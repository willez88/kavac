<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleSettingProductAttributesTable
 * @brief Agrega la tabla para la gestión de atributos de los productos
 *
 * Agrega la tabla para la gestión de atributos de los productos
 *
 * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreateSaleSettingProductAttributesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_setting_product_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table
                ->string('name', 100)->nullable()
                ->comment('Nombre o descripción del atributo o característica específica del producto');

            $table
                ->foreignId('sale_setting_product_id')
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
        Schema::dropIfExists('sale_setting_product_attributes');
    }
}
