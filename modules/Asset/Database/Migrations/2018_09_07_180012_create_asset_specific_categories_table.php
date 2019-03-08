<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetSpecificCategoriesTable
 * @brief Crear tabla de Categorias Especificas de Bienes
 * 
 * Gestiona la creación o eliminación de la tabla de Categorias Especificas de Bienes
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class CreateAssetSpecificCategoriesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_specific_categories')) {
            Schema::create('asset_specific_categories', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->integer('asset_subcategory_id')->unsigned()
                      ->comment('Identificador único de la subcategoria a la que pertenece el registro');
                $table->string('code',10)->comment('Codigo de la categoria específica');
                $table->string('name',100)->comment('Nombre de la Categoria específica del bien');
                
                $table->foreign('asset_subcategory_id')->references('id')->on('asset_subcategories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
                $table->unique(array('asset_subcategory_id', 'code','name'))->comment('Clave única para el registro');
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
        Schema::dropIfExists('asset_specific_categories');
    }
}
