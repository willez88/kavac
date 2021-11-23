<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldPassphraseToSignprofilesTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author Pedro Buitrago pbuitrago@cenditel.gob.ve
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AddFieldPassphraseToSignprofilesTable extends Migration
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
                $table->string('passphrase')->comment('frase de paso cifrada');
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
        if (Schema::hasColumn('signprofiles', 'passphrase'))  {
            Schema::table('signprofiles', function (Blueprint $table) {
                $table->dropColumn('passphrase');
            });
        }
    }
}
