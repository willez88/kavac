<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetRulesTable
 * @brief Crear tabla de reglas de bienes en inventario
 * 
 * Gestiona la creación o eliminación de las reglas de inventario
 * 
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class CreateAssetRulesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_rules')) {    
            Schema::create('asset_rules', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->integer('asset_inventory_id')->unsigned()->comment('Identificador único del articulo en la tabla de inventario de bienes');
                $table->foreign('asset_inventory_id')->references('id')->on('asset_inventories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('min')->nullable()->unsigned()->comment('Cantidad minima permitida en el inventario de bienes');

                $table->integer('user_id')->unsigned()->comment('Identificador único del usuario que realiza el cambio de regla');
                $table->foreign('user_id')->references('id')->on('users')
                      ->onDelete('restrict')->onUpdate('cascade');

                /**
                 * Fecha en que se registra el cambio de regla
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
        Schema::dropIfExists('asset_rules');
    }
}
