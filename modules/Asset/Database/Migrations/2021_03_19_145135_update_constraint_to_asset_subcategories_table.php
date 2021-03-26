<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateConstraintToAssetSubcategoriesTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UpdateConstraintToAssetSubcategoriesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('asset_subcategories')) {
            Schema::table('asset_subcategories', function (Blueprint $table) {
                $table->unique(['name'])->comment('Nombre de la Subcategoria del bien');
                if (has_index_key('asset_subcategories', 'asset_subcategories_asset_category_id_code_name_unique')) {
                    $table->dropForeign(['asset_category_id']);
                    $table->dropUnique(['asset_category_id', 'code', 'name']);
                    $table->foreign('asset_category_id')->references('id')->on('asset_categories')->onUpdate('cascade');
                    $table->unique(['asset_category_id', 'code'])->comment('Clave única para el registro');
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
        if (Schema::hasTable('asset_subcategories')) {
            Schema::table('asset_subcategories', function (Blueprint $table) {
                $table->dropUnique(['name']);

                if (has_index_key('asset_subcategories', 'asset_subcategories_asset_category_id_code_unique')) {
                    $table->dropForeign(['asset_category_id']);
                    $table->dropUnique(['asset_category_id', 'code']);
                    $table->foreign('asset_category_id')->references('id')->on('asset_categories')->onUpdate('cascade');
                    $table->unique(['asset_category_id', 'code', 'name'])->comment('Clave única para el registro');
                };
            });
        }
        Schema::enableForeignKeyConstraints();
    }
}
