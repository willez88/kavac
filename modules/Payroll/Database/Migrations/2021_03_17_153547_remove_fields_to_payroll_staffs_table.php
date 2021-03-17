<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class RemoveFieldsToPayrollStaffsTable
 * @brief Remueve los campos has_disability y disability de la tabla payroll_staffs
 *
 * Gestiona la creación o eliminación de campos en la tabla
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class RemoveFieldsToPayrollStaffsTable extends Migration
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
                if (Schema::hasColumn('payroll_staffs', 'has_disability')) {
                    $table->dropColumn('has_disability');
                };
                if (Schema::hasColumn('payroll_staffs', 'disability')) {
                    $table->dropColumn('disability');
                };
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
                if (!Schema::hasColumn('payroll_staffs', 'has_disability')) {
                    $table->boolean('has_disability')->default(false)->comment('¿Posee una discapacidad?');
                };
                if (!Schema::hasColumn('payroll_staffs', 'disability')) {
                    $table->string('disability', 200)->nullable()->comment('Descripción de la discapacidad');
                };
            });
        }
    }
}
