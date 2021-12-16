<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldDateVerificationToCitizenServiceRequestsTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AddFieldDateVerificationToCitizenServiceRequestsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('citizen_service_requests', function (Blueprint $table){
              
            if (!Schema::hasColumn('citizen_service_requests', 'date_verification'))
            {
                $table->date('date_verification')->nullable()->comment('Fecha de verificación');
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
        Schema::table('citizen_service_requests', function (Blueprint $table){
            
            if (Schema::hasColumn('citizen_service_requests', 'date_verification')) 
            {

                $table->dropColumn(['date_verification']);
            }
            
        });
    }
}
