<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldPayrollDisabilityIdToPayrollStaffsTable
 * @brief Agrega el campo payroll_disability_id a la tabla payroll_staffs
 *
 * Gestiona la creación o eliminación de campos en la tabla
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AddFieldPayrollDisabilityIdToPayrollStaffsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('payroll_staffs')) {
            Schema::table('payroll_staffs', function (Blueprint $table) {
                if (!Schema::hasColumn('payroll_staffs', 'payroll_disability_id')) {
                    $table->foreignId('payroll_disability_id')->nullable()
                          ->comment('Identificador de la discapacidad')->constrained()
                          ->onUpdate('cascade')->onDelete('restrict');
                }
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
        if (Schema::hasTable('payroll_staffs')) {
            Schema::table('payroll_staffs', function (Blueprint $table) {
                if (Schema::hasColumn('payroll_staffs', 'payroll_disability_id')) {
                    $table->dropForeign(['payroll_disability_id']);
                    $table->dropColumn('payroll_disability_id');
                }
            });
        }
    }
}
