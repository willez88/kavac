<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateConstraintToAssetCategoriesTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UpdateConstraintToAssetCategoriesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('asset_categories')) {
            Schema::table('asset_categories', function (Blueprint $table) {

                $table->dropUnique(['asset_type_id', 'code', 'name']);
                $table->unique(['asset_type_id', 'code'])->comment('Clave única para el registro');

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
        Schema::table('asset_categories', function (Blueprint $table) {

            $table->dropUnique(['asset_type_id', 'code']);
            $table->unique(['asset_type_id', 'code', 'name'])->comment('Clave única para el registro');
        });
    }
}
