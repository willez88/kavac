<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetInventariesTable
 * @brief Crear tabla de Inventario de Bienes Institucionales
 * 
 * Gestiona la creación o eliminación de la tabla de Inventario de Bienes
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class CreateAssetInventariesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_inventaries')) {
            Schema::create('asset_inventaries', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->integer('exist')->unsigned()->comment('Cantidad de artículos en existencia actualmente (Incluye a los reservados por solicitudes de bienes)');

                $table->integer('reserved')->unsigned()->nullable()->comment('Cantidad de artículos reservados por solicitudes de bienes que se han registrado en el sistema');

                $table->integer('asset_id')->unsigned()->comment('Identificador del bien en la tabla assets');
                $table->foreign('asset_id')->references('id')->on('assets')
                      ->onDelete('restrict')->onUpdate('cascade');
                 
                $table->integer('unit_value')->unsigned()->comment('Precio por unidad del bien');

                /**
                 * Fecha en la que se registra el bien en el inventario de bienes
                 */
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        };
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_inventaries');
    }
}
