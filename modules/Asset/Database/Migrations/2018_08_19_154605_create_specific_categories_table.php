<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSpecificCategoriesTable
 * @brief Crear tabla de categorias especificas de un bien
 * 
 * Gestiona la creación o eliminación de la tabla de categorias especificas de un bien
 * 
 * @author
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class CreateSpecificCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('specific_categories')) {
            Schema::create('specific_categories', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('asset_subcategory_id')->unsigned()
                      ->comment('Identificador de la subcategoria a la que pertenece el registro');
                $table->integer('code')->unsigned()
                      ->comment('Codigo de la categoria específica');
                $table->string('name',100)->comment('Categoria específica del bien');
                
                $table->foreign('asset_subcategory_id')->references('id')->on('subcategories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specific_categories');
    }
}
