<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetDisincorporationAssetsTable
 * @brief Crear tabla de los bienes institucionales desincorporados
 *
 * Gestiona la creación o eliminación de la tabla de bienes institucionales asociados a una desincorporación
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateAssetDisincorporationAssetsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_disincorporation_assets')) {
            Schema::create('asset_disincorporation_assets', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->foreignId('asset_id')->nullable()->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->foreignId('asset_disincorporation_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
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
        Schema::dropIfExists('asset_disincorporation_assets');
    }
}
