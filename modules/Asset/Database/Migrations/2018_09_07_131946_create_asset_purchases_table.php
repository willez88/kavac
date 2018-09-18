<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetPurchasesTable
 * @brief Crear tabla de Formas de Adquisición
 * 
 * Gestiona la creación o eliminación de la tabla de Formas de adquisición de un bien
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class CreateAssetPurchasesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_purchases')) {
            Schema::create('asset_purchases', function (Blueprint $table) {
                
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('name',100)->comment('Nombre de la forma de adquisición');

                $table->timestamps();
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
        Schema::dropIfExists('asset_purchases');
    }
}
