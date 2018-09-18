<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateTypesTable
 * @brief Crear tabla de Tipos de Bienes
 * 
 * Gestiona la creación o eliminación de la tabla de tipos de bienes
 * 
 * @author
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('types')) {
            Schema::create('types', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name',100)->comment('Tipo de bien');

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
        Schema::dropIfExists('types');
    }
}
