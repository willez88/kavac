<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetDisincorporationMotivesTable
 * @brief Crear tabla de motivos de desincorporacion de bienes
 * 
 * Gestiona la creación o eliminación de los motivos de desincorporacion de bienes
 * 
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class CreateAssetDisincorporationMotivesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_disincorporation_motives')) {
            Schema::create('asset_disincorporation_motives', function (Blueprint $table) {
            
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('name',100)->comment('Nombre del motivo de la desincorporación');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
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
        Schema::dropIfExists('asset_disincorporation_motives');
    }
}
