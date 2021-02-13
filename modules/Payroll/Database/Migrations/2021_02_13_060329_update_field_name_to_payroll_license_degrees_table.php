<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldNameToPayrollLicenseDegreesTable
 * @brief Actualiza campos de la tabla licencias de conducir
 *
 * Gestiona la creación o eliminación de campos de la tabla licencias de conducir
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UpdateFieldNameToPayrollLicenseDegreesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_license_degrees', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_license_degrees', 'name')) {
                $table->string('name')->unique()->change();
            };
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_license_degrees', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_license_degrees', 'name')) {
                $table->dropUnique(['name']);
                $table->string('name')->change();
            };
        });
    }
}
