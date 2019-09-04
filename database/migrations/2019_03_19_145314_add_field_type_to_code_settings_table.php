<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldTypeToCodeSettingsTable
 * @brief Migración para agregar campo type al modelo Setting
 *
 * Agrega un campo type al modelo Setting
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldTypeToCodeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('code_settings', 'type')) {
            Schema::table('code_settings', function (Blueprint $table) {
                $table->string('type')->nullable()
                      ->comment(
                          "Define un tipo de registro en caso de que en un mismo modelo se registre " .
                          "distinta información"
                      );
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
        Schema::table('code_settings', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
