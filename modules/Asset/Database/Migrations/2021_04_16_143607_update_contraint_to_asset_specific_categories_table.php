<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateContraintToAssetSpecificCategoriesTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [Yennifer Ramirez] [yramirez@cenditel.gob.ve]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UpdateContraintToAssetSpecificCategoriesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('asset_specific_categories')) {
            Schema::table('asset_specific_categories', function (Blueprint $table) {

                if (has_index_key(
                    'asset_specific_categories',
                    'asset_specific_categories_asset_subcategories_id_code_name_unique'
                )) {
                        $table->dropForeign(['asset_subcategories_id']);
                        $table->dropUnique(['asset_subcategories_id', 'code', 'name']);
                        $table->foreign('asset_subcategories_id')->references('id')
                        ->on('asset_subcategories')->onUpdate('cascade');
                        $table->unique(['asset_subcategories_id', 'code'])->comment('Clave única para el registro');
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
        if (Schema::hasTable('asset_specific_categories')) {
            Schema::table('asset_specific_categories', function (Blueprint $table) {
                

                if (has_index_key(
                    'asset_specific_categories',
                    'asset_specific_categories_asset_subcategories_id_code_unique'
                )) {
                    $table->dropForeign(['asset_subcategories_id']);
                    $table->dropUnique(['asset_subcategories_id', 'code']);
                    $table->foreign('asset_subcategories_id')->references('id')
                    ->on('asset_subcategories')->onUpdate('cascade');
                    $table->unique(['asset_subcategories_id', 'code', 'name'])->comment('Clave única para el registro');
                };
            });
            Schema::enableForeignKeyConstraints();
        }
    }
}
