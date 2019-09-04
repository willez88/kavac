<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetInventoryAssetsTable
 * @brief Crear tabla de los bienes institucionales asociados a un registro de inventario
 *
 * Gestiona la creación o eliminación de la tabla de bienes institucionales asociados a un registro de inventario
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateAssetInventoryAssetsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_inventory_assets')) {
            Schema::create('asset_inventory_assets', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->string('asset_condition')->nullable()->comment('Condicion física actual del bien');
                $table->string('asset_status')->nullable()->comment('Estatus de uso actual del bien');
                $table->string('asset_use_function')->nullable()->comment('Función de uso actual del bien');

                $table->integer('asset_id')->unsigned()->nullable()
                      ->comment('Identificador único del bien en la tabla de bienes');
                $table->foreign('asset_id')->references('id')->on('assets')->onDelete('restrict')->onUpdate('cascade');

                $table->integer('asset_inventory_id')->unsigned()->nullable()
                      ->comment('Identificador único del registro de inventario generado');
                $table->foreign('asset_inventory_id')->references('id')->on('asset_inventories')
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
        Schema::dropIfExists('asset_inventory_assets');
    }
}
