<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetsDisincorporationsTable
 * @brief Crear tabla Desincorporación de Bienes
 * 
 * Gestiona la creación o eliminación de las Desincorporaciones de los Bienes Institucionales
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class CreateAssetDisincorporationsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_disincorporations')) {
            Schema::create('asset_disincorporations', function (Blueprint $table) {
                $table->increments('id');

                $table->integer('asset_id')->nullable()->unsigned()
                      ->comment('Identificador único de la asignación de un bien');
                $table->foreign('asset_id')->references('id')->on('assets');

                $table->integer('motive_id')->nullable()->unsigned()->comment('Identificador único del Motivo de la desincorporación del bien');
                $table->foreign('motive_id')->references('id')->on('asset_motive_disincorporations');

                $table->date('date')->nullable()->comment('Fecha de la desincorporación del bien');

                $table->string('observation')->nullable()->comment('Observaciones generales del estado del bien a desincorporar');
                /**
                 * Fecha en la que se realiza la desincoporación
                **/
                $table->timestamps();

                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
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
        Schema::dropIfExists('asset_disincorporations');
    }
}
