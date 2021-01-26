<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class DeleteSaleCodeFormatsTable
 * @brief Elimina la tabla de formato de códigos en comercializacion
 *
 * Elimina la tabla de formato de códigos
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class DeleteSaleCodeFormatsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('sale_code_formats');
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('sale_code_formats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('formatcode', 17)->unique()->comment('Format code');
            $table->string('type_formatcode', 50)->comment('Type of Format code');
            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
        });
    }
}
