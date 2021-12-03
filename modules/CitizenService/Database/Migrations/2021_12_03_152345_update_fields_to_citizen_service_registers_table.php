<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldsToCitizenServiceRegistersTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UpdateFieldsToCitizenServiceRegistersTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('citizen_service_registers', function (Blueprint $table) {

            if (Schema::hasColumn('citizen_service_registers', 'first_name')) {
                $table->dropColumn(['first_name']);
            }
            if (!Schema::hasColumn('citizen_service_registers', 'payroll_staff_id')) {
                $table->foreignId('payroll_staff_id')->nullable()->constrained()
                  ->onDelete('restrict')->onUpdate('cascade');    
            }
            if (!Schema::hasColumn('citizen_service_registers', 'team_name')) {
                $table->string('team_name', 200)->nullable()->comment('team_name');
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
        Schema::table('citizen_service_registers', function (Blueprint $table) {

            if (!Schema::hasColumn('citizen_service_registers', 'first_name')) {
                $table->string('first_name', 100)->nullable()->comment('first_name');
            }
            if (Schema::hasColumn('citizen_service_registers', 'payroll_staff_id')) {
                $table->dropForeign(['payroll_staff_id']);
                $table->dropColumn('payroll_staff_id');
            }
            if (Schema::hasColumn('citizen_service_registers', 'team_name')) {
                $table->dropColumn(['team_name']);
            }





            
        });
    }
}
