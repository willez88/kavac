<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldToCitizenServiceRequestsTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UpdateFieldToCitizenServiceRequestsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('citizen_service_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('citizen_service_requests', 'attribute')) {
                $table->string('attribute', 200)->nullable()->comment('Atributos');
            }
            if (!Schema::hasColumn('citizen_service_requests', 'parish_id')) {
                $table->foreignId('parish_id')->nullable()->constrained()->onDelete('restrict')->onUpdate('cascade');
            }

            if (Schema::hasColumn('citizen_service_requests', 'municipality_id')) {
                $table->dropForeign(['municipality_id']);
                $table->dropColumn('municipality_id');
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
        Schema::table('citizen_service_requests', function (Blueprint $table) {
            if (Schema::hasColumn('citizen_service_requests', 'attribute')) {
                $table->dropColumn(['attribute']);
            }
            if (Schema::hasColumn('citizen_service_requests', 'parish_id')) {
                $table->dropForeign(['parish_id']);
                $table->dropColumn('parish_id');
            }
            if (!Schema::hasColumn('citizen_service_requests', 'municipality_id')) {
                $table->foreignId('municipality_id')->nullable()->constrained()->onDelete('restrict')->onUpdate('cascade');
            }

            
        });
    }
}
