<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFielAttributesToSubservices
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AddFielAttributesToSubservices extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_list_subservices', function (Blueprint $table) {
            $table->boolean('define_attributes')->default(false)
                      ->comment('Establecer atributos personalizados. (true) si, (false) no');
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_list_subservices', function (Blueprint $table) {
             if (Schema::hasColumn('sale_list_subservices', 'define_attributes')) {
                //$table->dropUnique(['define_attributes']);
                $table->dropColumn('define_attributes');
            }
        });
    }
}

