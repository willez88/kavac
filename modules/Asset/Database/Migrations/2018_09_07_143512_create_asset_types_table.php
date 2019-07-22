<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


/**
 * @class CreateAssetTypesTable
 * @brief Crear tabla de tipos de bienes
 * 
 * Gestiona la creación o eliminación de la tabla de tipos de bienes
 * 
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class CreateAssetTypesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_types')) {
            Schema::create('asset_types', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('name',100)->comment('Nombre del tipo de bien');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');

                $table->unique(array('name'))->comment('Clave única para el registro');
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
        Schema::dropIfExists('asset_types');
    }
}
