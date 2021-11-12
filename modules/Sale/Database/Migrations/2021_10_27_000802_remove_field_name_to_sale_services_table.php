<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class RemoveFieldNameToSaleServicesTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class RemoveFieldNameToSaleServicesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_services', function (Blueprint $table) {
            if (Schema::hasColumn('sale_services', 'name')) {
                $table->dropColumn('name');
            }
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_services', function (Blueprint $table) {
            if (!Schema::hasColumn('sale_services', 'name')) {
                $table->string('name', 100)->nullable()->comment('Nombre del solicitante');
            }
        });
    }
}
