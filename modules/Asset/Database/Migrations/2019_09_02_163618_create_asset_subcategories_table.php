<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetSubcategoriesTable
 * @brief Crear tabla de las subcategorias de bienes institucionales
 *
 * Gestiona la creación o eliminación de la tabla de subcategorias de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateAssetSubcategoriesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_subcategories')) {
            Schema::create('asset_subcategories', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');
                $table->string('code', 10)->comment('Código de la subcategoria');
                $table->string('name', 100)->comment('Nombre de la Subcategoria del bien');

                $table->bigInteger('asset_category_id')->unsigned()
                      ->comment('Identificador del tipo de categoria del bien');
                $table->foreign('asset_category_id')->references('id')->on('asset_categories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');

                $table->unique(['asset_category_id', 'code','name'])->comment('Clave única para el registro');
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
        Schema::dropIfExists('asset_subcategories');
    }
}
