<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetInventoriesTable
 * @brief Crear tabla de inventario de bienes institucionales
 * 
 * Gestiona la creación o eliminación de la tabla de inventario de bienes
 * 
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class CreateAssetInventoriesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_inventories')) {
            Schema::create('asset_inventories', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('code', 20)->unique()->comment('Código identificador del inventario');
                $table->integer('registered')->unsigned()->default(0)->comment('Cantidad de bienes en registrados');
                $table->integer('assigned')->unsigned()->default(0)->comment('Cantidad de bienes en asignados');
                $table->integer('disincorporated')->unsigned()->default(0)->comment('Cantidad de bienes en desincorporados');
                $table->integer('reserved')->unsigned()->default(0)->comment('Cantidad de bienes reservados por solicitudes registradas en el sistema');

                /**
                 * Fecha en la que se registra el inventario actual de bienes
                 */
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
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
        Schema::dropIfExists('asset_inventories');
    }
}
