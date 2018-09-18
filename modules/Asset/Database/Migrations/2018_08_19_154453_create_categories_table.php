<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


/**
 * @class CreateCategoriesTable
 * @brief Crear tabla de categorias de un Bien
 * 
 * Gestiona la creación o eliminación de la tabla de categorias generales de un bien
 * 
 * @author
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('asset_type_id')->unsigned()
                      ->comment('Identificador del tipo de bien');
                $table->integer('code')->unsigned()
                      ->comment('Codigo de la categoria general');
                $table->string('name',100)->comment('Categoria general del bien');
                
                $table->foreign('asset_type_id')->references('id')->on('types')
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
        Schema::dropIfExists('categories');
    }
}
