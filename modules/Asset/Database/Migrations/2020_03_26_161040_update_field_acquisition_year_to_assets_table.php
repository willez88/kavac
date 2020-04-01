<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldAcquisitionYearToAssetsTable
 * @brief Actualiza el campos año de adquisición de la tabla de bienes
 *
 * Gestiona la actualización del campo año de adquisición de la tabla de bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class UpdateFieldAcquisitionYearToAssetsTable extends Migration
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
                if (Schema::hasColumn('assets', 'acquisition_year')) {
                    $table->date('acquisition_date')->nullable()->unsigned()->comment('Fecha de adquisicion del bien');
                    $table->dropColumn('acquisition_year');
                }
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
                if (Schema::hasColumn('assets', 'acquisition_date')) {
                    $table->year('acquisition_year')->nullable()->unsigned()->comment('Año de adquisicion del bien');
                    $table->dropColumn('acquisition_date');
                }
            });
        }
    }
}
