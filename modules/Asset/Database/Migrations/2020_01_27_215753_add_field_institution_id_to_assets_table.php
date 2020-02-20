<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldInstitutionIdToAssetsTable
 * @brief Agregar campo institución a la tabla de bienes registrados
 *
 * Gestiona la creación o eliminación del campo institución de la tabla de bienes registrados
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldInstitutionIdToAssetsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('assets')) {
            Schema::table('assets', function (Blueprint $table) {
                if (!Schema::hasColumn('assets', 'institution_id')) {
                    $table->bigInteger('institution_id')->unsigned()->nullable()
                        ->comment('Identificador único de la institución a la que pertenece el bien');
                    $table->foreign('institution_id')
                        ->references('id')->on('institutions')
                        ->onDelete('restrict')->onUpdate('cascade');
                };
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('assets')) {
            Schema::table('assets', function (Blueprint $table) {
                if (Schema::hasColumn('assets', 'institution_id')) {
                    $table->dropForeign(['institution_id']);
                    $table->dropColumn('institution_id');
                };
            });
        };
    }
}
