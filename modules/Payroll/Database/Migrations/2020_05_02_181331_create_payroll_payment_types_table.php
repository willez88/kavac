<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      CreatePayrollPaymentTypesTable
 * @brief      Crea la tabla de tipos de pago
 *
 * Gestiona la creación o eliminación de la tabla tipos de pago
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePayrollPaymentTypesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_payment_types')) {
            Schema::create('payroll_payment_types', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');
                $table->string('code')->comment('Código del tipo de pago');
                $table->string('name')->comment('Nombre del tipo de pago');

                $table->enum(
                    'payment_periodicity',
                    [
                        'daily', 'weekly', 'biweekly', 'monthly', 'bimonthly', 'three-monthly',
                        'four-monthly', 'biannual', 'annual', 'not_apply'
                    ]
                )->comment('Periodicidad de pago (daily, weekly, biweekly, monthly, bimonthly, ' .
                        'three-monthly, four-monthly, biannual, annual, not_apply)');
                $table->boolean('correlative')->default(false)
                      ->comment('Indica si el tipo de pago es correlativo al expediente del trabajador');
                $table->date('start_date')->comment('Fecha de inicio del primer período');
                $table->enum(
                    'payment_relationship',
                    [
                        'payroll', 'comprehensive_wages', 'utilities', 'vacations',
                        'social_benefits_guarantees', 'social_benefit_interests', 'liquidations',
                        'ticket_basket', 'kindergarten', 'special_payroll', 'others'
                    ]
                )->comment('Relación de pago (payroll, comprehensive_wages, utilities, vacations, ' .
                    'social_benefits_guarantees, social_benefit_interests, liquidations, ' .
                    'ticket_basket, kindergarten, special_payroll, others)');

                $table->foreignId('accounting_account_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
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
        Schema::dropIfExists('payroll_payment_types');
    }
}
