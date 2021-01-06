<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      UpdateFieldsToPayrollPaymentTypesTable
 * @brief      Actualiza los campos de la tabla de tipos de pago de nómina
 *
 * Gestiona la creación o eliminación de los campos de la tabla de tipos de pago de nómina
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UpdateFieldsToPayrollPaymentTypesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (Schema::hasTable('payroll_payment_types')) {
            Schema::table('payroll_payment_types', function (Blueprint $table) {
                if (Schema::hasColumn('payroll_payment_types', 'code')) {
                    $table->unique('code');
                }
                if (!Schema::hasColumn('payroll_payment_types', 'budget_account_id')) {
                    $table->foreignId('budget_account_id')->nullable()
                          ->comment('Identificador único asociado a la cuenta presupuestaria')
                          ->constrained()->onDelete('restrict')->onUpdate('cascade');
                }
                if (!Schema::hasColumn('payroll_payment_types', 'associated_records')) {
                    $table->longText('associated_records')->nullable()
                          ->comment('Campos del expediente del trabajador a usar en la relación de pago');
                }
            });
        };
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_payment_types', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_payment_types', 'code')) {
                $table->dropUnique(['code']);
            }
            if (Schema::hasColumn('payroll_payment_types', 'budget_account_id')) {
                $table->dropForeign(['budget_account_id']);
                $table->dropColumn('budget_account_id');
            }
            if (Schema::hasColumn('payroll_payment_types', 'associated_records')) {
                $table->dropColumn('associated_records');
            }
        });
    }
}
