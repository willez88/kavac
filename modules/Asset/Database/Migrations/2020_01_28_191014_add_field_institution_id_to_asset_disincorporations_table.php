<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldInstitutionIdToAssetDisincorporationsTable
 * @brief Agrega el campo institución a la tabla de desincorporaciones de bienes
 *
 * Gestiona la creación o eliminación del campo institución de la tabla de desincorporaciones de bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldInstitutionIdToAssetDisincorporationsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('asset_disincorporations')) {
            Schema::table('asset_disincorporations', function (Blueprint $table) {
                if (!Schema::hasColumn('asset_disincorporations', 'institution_id')) {
                    $table->bigInteger('institution_id')->unsigned()->nullable()
                          ->comment('Identificador único de la institución asociada al registro');
                    $table->foreign('institution_id')
                          ->references('id')->on('institutions')
                          ->onDelete('restrict')->onUpdate('cascade');
                };
            });
        };
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('asset_disincorporations')) {
            Schema::table('asset_disincorporations', function (Blueprint $table) {
                if (Schema::hasColumn('asset_disincorporations', 'institution_id')) {
                    $table->dropForeign(['institution_id']);
                    $table->dropColumn(['institution_id']);
                };
            });
        };
    }
}
