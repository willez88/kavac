<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetRulesTable
 * @brief Crear tabla de Reglas de Bienes en Inventario
 * 
 * Gestiona los cambios en las reglas de cantidad minima por cada bien en el inventario
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class CreateAssetRulesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_rules')) {    
            Schema::create('asset_rules', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->integer('asset_inventary_id')->unsigned()->comment('Identificador único del articulo en la tabla de inventario de bienes');
                $table->foreign('asset_inventary_id')->references('id')->on('asset_inventaries')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('min')->nullable()->unsigned()->comment('Cantidad minima permitida en el inventario de bienes');

                $table->integer('user_id')->unsigned()->comment('Identificador único del usuario que realiza el cambio de regla');
                $table->foreign('user_id')->references('id')->on('users')
                      ->onDelete('restrict')->onUpdate('cascade');

                /**
                 * Fecha en que se registra el cambio de regla
                 */
                $table->timestamps();
            });
        };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_rules');
    }
}
