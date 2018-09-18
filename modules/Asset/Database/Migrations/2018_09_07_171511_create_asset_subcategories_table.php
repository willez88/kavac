<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetSubcategoriesTable
 * @brief Crear tabla de Subcategorias de Bienes
 * 
 * Gestiona la creación o eliminación de la tabla de Subcategorias de Bienes
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class CreateAssetSubcategoriesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_subcategories')) {
            Schema::create('asset_subcategories', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->integer('asset_category_id')->unsigned()->comment('Identificador del tipo de categoria del bien');
                $table->string('code',10)->comment('Código de la subcategoria');
                $table->string('name',100)->comment('Nombre de la Subcategoria del bien');

                $table->foreign('asset_category_id')->references('id')->on('asset_categories')
                      ->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('asset_subcategories');
    }
}
