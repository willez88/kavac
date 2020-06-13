<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldInstitutionIdToAssetRequestsTable
 * @brief Agrega el campo institución a la tabla de solicitudes de bienes
 *
 * Gestiona la creación o eliminación del campo institución de la tabla de solicitudes de bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldInstitutionIdToAssetRequestsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('asset_requests')) {
            Schema::table('asset_requests', function (Blueprint $table) {
                if (!Schema::hasColumn('asset_requests', 'institution_id')) {
                    $table->foreignId('institution_id')->nullable()->constrained()
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
        if (Schema::hasTable('asset_requests')) {
            Schema::table('asset_requests', function (Blueprint $table) {
                if (Schema::hasColumn('asset_requests', 'institution_id')) {
                    $table->dropForeign(['institution_id']);
                    $table->dropColumn(['institution_id']);
                };
            });
        };
    }
}
