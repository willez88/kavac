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
        Schema::disableForeignKeyConstraints();
        if (Schema::hasTable('asset_categories')) {
            Schema::table('asset_categories', function (Blueprint $table) {
                if (has_index_key('asset_categories', 'asset_categories_asset_type_id_code_name_unique')) {
                    $table->dropUnique(['asset_type_id', 'code', 'name']);
                    $table->unique(['asset_type_id', 'code'])->comment('Clave única para el registro');
                };

            });
        }
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        if (Schema::hasTable('asset_categories')) {
            Schema::table('asset_categories', function (Blueprint $table) {
                if (has_index_key('asset_categories', 'asset_categories_asset_type_id_code_unique')) {
                    $table->dropUnique(['asset_type_id', 'code']);
                    $table->unique(['asset_type_id', 'code', 'name'])->comment('Clave única para el registro');
                };

            });
        }
        Schema::enableForeignKeyConstraints();
    }
}
