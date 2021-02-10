<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldNameToPayrollStaffClassificationsTable
 * @brief Actualiza campos de la tabla clasificación del personal
 *
 * Gestiona la creación o eliminación de campos de la tabla clasificación del personal
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UpdateFieldNameToPayrollStaffClassificationsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_staff_classifications', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_staff_classifications', 'name')) {
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
        Schema::table('payroll_staff_classifications', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_staff_classifications', 'name')) {
                $table->dropUnique(['name']);
                $table->string('name')->change();
            };
        });
    }
}
