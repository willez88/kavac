<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldUniformSizeAndMedicalHistoryToPayrollStaffsTable
 * @brief Agrega los campos uniform_size y medical_history a la tabla payroll_staffs
 *
 * Gestiona la creación o eliminación de campos en la tabla
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AddFieldUniformSizeAndMedicalHistoryToPayrollStaffsTable extends Migration
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
                if (!Schema::hasColumn('payroll_staffs', 'uniform_size')) {
                    $table->integer('uniform_size')->default(0)->comment('Talla de uniforme');
                }
                if (!Schema::hasColumn('payroll_staffs', 'medical_history')) {
                    $table->text('medical_history')->nullable()->comment('Historial médico');
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
                if (Schema::hasColumn('payroll_staffs', 'uniform_size')) {
                    $table->dropColumn('uniform_size');
                }
                if (Schema::hasColumn('payroll_staffs', 'medical_history')) {
                    $table->dropColumn('medical_history');
                }
            });
        }
    }
}
