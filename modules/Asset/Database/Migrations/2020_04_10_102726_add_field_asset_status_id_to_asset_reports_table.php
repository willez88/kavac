<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      AddFieldAssetStatusIdToAssetReportsTable
 * @brief      Agrega el campo asset_status_id a la tabla asset_reports
 *
 * Gestiona la creación o eliminación del campo  asset_status_id de la tabla asset_reports
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class AddFieldAssetStatusIdToAssetReportsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (Schema::hasTable('asset_reports')) {
            Schema::table('asset_reports', function (Blueprint $table) {
                if (!Schema::hasColumn('asset_reports', 'asset_status_id')) {
                    $table->bigInteger('asset_status_id')->unsigned()->nullable()
                          ->comment('Identificador único del estatus de uso asociado al bien');
                }
            });
        };
    }

    /**
     * Método que elimina las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function down()
    {
        if (Schema::hasTable('asset_reports')) {
            Schema::table('asset_reports', function (Blueprint $table) {
                if (Schema::hasColumn('asset_reports', 'asset_status_id')) {
                    $table->dropColumn(['asset_status_id']);
                };
            });
        };
    }
}
