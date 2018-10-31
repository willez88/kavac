<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetMotiveDisincorporationsTable
 * @brief Crear tabla de motivos de desincorporacion de bienes
 * 
 * Gestiona la creación o eliminación de los motivos de desincorporacion de bienes
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class CreateAssetMotiveDisincorporationsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_motive_disincorporations')) {
            Schema::create('asset_motive_disincorporations', function (Blueprint $table) {
            
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('name',100)->comment('Nombre del Motivo de la Desincorporación');

                $table->timestamps();
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_motive_disincorporations');
    }
}
