<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      AddFieldPayrollPaymentTypeIdToPayrollBenefitsPoliciesTable
 * @brief      Agrega el campo tipo de pago de nómina a la tabla de políticas de prestaciones
 *
 * Gestiona la creación o eliminación del campo tipo de pago de nómina de la tabla de políticas de prestaciones
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AddFieldPayrollPaymentTypeIdToPayrollBenefitsPoliciesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (Schema::hasTable('payroll_benefits_policies')) {
            Schema::table('payroll_benefits_policies', function (Blueprint $table) {
                if (!Schema::hasColumn('payroll_benefits_policies', 'payroll_payment_type_id')) {
                    $table->foreignId('payroll_payment_type_id')->nullable()
                          ->comment('Identificador único asociado al tipo de pago de nómina')
                          ->constrained()->onDelete('restrict')->onUpdate('cascade');
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
        Schema::table('payroll_benefits_policies', function (Blueprint $table) {
            //
        });
    }
}
