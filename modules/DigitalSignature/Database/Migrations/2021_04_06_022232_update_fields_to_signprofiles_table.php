<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldsToSignprofilesTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author Pedro Buitrago pbuitrago@cenditel.gob.ve
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UpdateFieldsToSignprofilesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('signprofiles')) {
            Schema::table('signprofiles', function (Blueprint $table) {
                $table->string('cert','12000')->change();
                $table->string('pkey','4000')->change();
            });
        }
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('signprofiles')) { 
            Schema::table('signprofiles', function (Blueprint $table) {
                $table->string('cert','3000')->change();
                $table->string('pkey','2000')->change();
            });
        }
    }
}
