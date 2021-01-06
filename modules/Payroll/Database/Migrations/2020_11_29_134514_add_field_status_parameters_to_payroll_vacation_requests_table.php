<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      AddFieldStatusParametersToPayrollVacationRequestsTable
 * @brief      Agrega el campo parámetros del estatus a la tabla de solicitudes de vacaciones
 *
 * Gestiona la creación o eliminación del campo parámetros del estatus a la tabla de solicitudes de vacaciones
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AddFieldStatusParametersToPayrollVacationRequestsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (Schema::hasTable('payroll_vacation_requests')) {
            Schema::table('payroll_vacation_requests', function (Blueprint $table) {
                if (!Schema::hasColumn('payroll_vacation_requests', 'status_parameters')) {
                    $table->text('status_parameters')->nullable()->comment(
                        'Parámetros del estatus: Si estatus aprobado = {reincorporation_date, payment_amount} ' .
                        'Si estatus rejected = {motive}'
                    );
                };
            });
        };
    }

    /**
     * Método que elimina las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function down()
    {
        if (Schema::hasTable('payroll_vacation_requests')) {
            Schema::table('payroll_vacation_requests', function (Blueprint $table) {
                $table->dropColumn('status_parameters');
            });
        };
    }
}
