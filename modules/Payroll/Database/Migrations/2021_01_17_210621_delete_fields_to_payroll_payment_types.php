<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class     DeleteFieldsToPayrollPaymentTypes
 * @brief     Actualiza los campos de la tabla de políticas vacacionales
 *
 * Gestiona la creación o eliminación de los campos de la tabla tipos de pago
 *
 * @author    Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class DeleteFieldsToPayrollPaymentTypes extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (Schema::hasTable('payroll_payment_types')) {
            Schema::table('payroll_payment_types', function (Blueprint $table) {
                if (Schema::hasColumn('payroll_payment_types', 'accounting_account_id')) {
                    $table->dropForeign(['accounting_account_id']);
                    $table->dropColumn('accounting_account_id');
                };
                if (Schema::hasColumn('payroll_payment_types', 'budget_account_id')) {
                    $table->dropForeign(['budget_account_id']);
                    $table->dropColumn('budget_account_id');
                };
                
            });
        };
    }

    /**
     * Revierte las migraciones.
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function down()
    {
    }
}
