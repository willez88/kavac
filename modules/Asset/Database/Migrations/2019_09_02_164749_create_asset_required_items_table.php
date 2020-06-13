<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetRequiredItemsTable
 * @brief Crear tabla de los campos requeridos de una clasificación de bienes institucionales
 *
 * Gestiona la creación o eliminación de la tabla de campos requeridos de una clasificación de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateAssetRequiredItemsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_required_items')) {
            Schema::create('asset_required_items', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->boolean('use_function')->default(false)->comment('Define si la función de uso es requerida');
                $table->boolean('serial')->default(false)->comment('Define si el serial es requerido');
                $table->boolean('marca')->default(false)->comment('Define si la marca es requerida');
                $table->boolean('model')->default(false)->comment('Define si el modelo es requerido');
                $table->boolean('address')->default(false)->comment('Define si la dirección es requerida');

                $table->foreignId('asset_specific_category_id')->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->unique(['asset_specific_category_id'])->comment('Clave única para el registro');
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
        Schema::dropIfExists('asset_required_items');
    }
}
