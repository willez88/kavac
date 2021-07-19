<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldPayrollProfessionalIdToPayrollClassSchedulesTable
 * @brief Actualiza campos de la tabla horarios de clase
 *
 * Gestiona la creación o eliminación de campos de la tabla horarios de clase
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UpdateFieldPayrollProfessionalIdToPayrollClassSchedulesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_class_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_class_schedules', 'payroll_professional_id')) {
                $table->foreignId('payroll_professional_id')->unique()->change();
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
        Schema::table('payroll_class_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_class_schedules', 'payroll_professional_id')) {
                $table->dropForeign(['payroll_professional_id']);
                $table->dropUnique(['payroll_professional_id']);
                $table->foreign('payroll_professional_id')->references('id')->on('payroll_professionals')
                      ->onUpdate('cascade')->onDelete('restrict');
            }
        });
    }
}
