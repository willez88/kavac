<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class ChangeDescriptionToPurchaseTypesTable
 * @brief Agrega la propiedad nullable a la columna description de la tabla purchase_types
 *
 * Agrega la propiedad nullable a la columna description
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class ChangeDescriptionToPurchaseTypesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_types', function (Blueprint $table) {
            $table->string('description')->nullable()
                ->comment('Descripción del tipo de compra de compra')->change();
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        // 
    }
}
