<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddUniqueFieldToAssetConditionsTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AddUniqueFieldToAssetConditionsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('asset_conditions')) {
            Schema::table('asset_conditions', function (Blueprint $table) {

                $table->unique(['name'])->comment('Nombre de la condición física del bien');
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
        Schema::table('asset_conditions', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });
    }
}
