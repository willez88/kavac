<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldsToAssetReportsTable
 * @brief Actualizar campos de la tabla de reportes generados en el módulo de bienes
 *
 * Gestiona la creación o eliminación de los campos de la tabla de reportes generados en el módulo de bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class UpdateFieldsToAssetReportsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('asset_reports')) {
            Schema::table('asset_reports', function (Blueprint $table) {
                if (!Schema::hasColumn('asset_reports', 'document_id')) {
                    $table->bigInteger('document_id')->unsigned()->nullable()
                          ->comment('Identificador único del documento físico asociado al reporte');
                    $table->foreign('document_id')
                          ->references('id')->on('documents')
                          ->onDelete('restrict')->onUpdate('cascade');
                };
                if (!Schema::hasColumn('asset_reports', 'status')) {
                    $table->string('status', 25)->default('Pendiente por ejecutar')->comment('Estado del documento');
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
        if (Schema::hasTable('asset_reports')) {
            Schema::table('asset_reports', function (Blueprint $table) {
                if (Schema::hasColumn('asset_reports', 'document_id')) {
                    $table->dropForeign(['document_id']);
                    $table->dropColumn('document_id');
                };
                if (Schema::hasColumn('asset_reports', 'status')) {
                    $table->dropColumn('status');
                };
            });
        };
    }
}
