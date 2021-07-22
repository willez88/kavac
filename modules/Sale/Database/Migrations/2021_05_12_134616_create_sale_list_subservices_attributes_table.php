<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleListSubservicesAttributesTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreateSaleListSubservicesAttributesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sale_list_subservices_attributes')) {
            Schema::create('sale_list_subservices_attributes', function (Blueprint $table) {
                $table->id('id')->comment('Identificador único del registro');

                $table->string('value', 100)->comment('Valor o descripción del atributo');
                $table->foreignId('sale_list_subservices_id')->constrained()
                      ->index('sale_list_subservices_id_foreign')->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_list_subservices_attributes');
    }
}
