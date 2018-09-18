<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSubcategoriesTable
 * @brief Crear tabla de subcategorias de un bien
 * 
 * Gestiona la creación o eliminación de la tabla de subcategorias de un bien
 * 
 * @author
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class CreateSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('subcategories')) {
            Schema::create('subcategories', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('asset_category_id')->unsigned()
                      ->comment('Identificador del tipo de categoria del bien');
                $table->integer('code')->unsigned()
                      ->comment('Codigo de la subcategoria');
                $table->string('name',100)->comment('subcategoria del bien');

                $table->foreign('asset_category_id')->references('id')->on('categories')
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
        Schema::dropIfExists('subcategories');
    }
}
