<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetSpecificCategoriesTable
 * @brief Crear tabla de las categorias específicas de bienes institucionales
 *
 * Gestiona la creación o eliminación de la tabla de categorias específicas de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateAssetSpecificCategoriesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_specific_categories')) {
            Schema::create('asset_specific_categories', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('code', 10)->comment('Código de la categoria específica');
                $table->string('name', 100)->comment('Nombre de la categoria específica del bien');
                
                $table->integer('asset_subcategory_id')->unsigned()
                      ->comment('Identificador único de la subcategoria a la que pertenece el registro');
                $table->foreign('asset_subcategory_id')->references('id')->on('asset_subcategories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');

                $table->unique(['asset_subcategory_id', 'code','name'])->comment('Clave única para el registro');
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
        Schema::dropIfExists('asset_specific_categories');
    }
}
