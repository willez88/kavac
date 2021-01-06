<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      UpdateFieldsToPayrollVacationPoliciesTable
 * @brief      Actualiza los campos de la tabla de políticas vacacionales
 *
 * Gestiona la creación o eliminación de los campos de la tabla de políticas vacacionales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UpdateFieldsToPayrollVacationPoliciesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (Schema::hasTable('payroll_vacation_policies')) {
            Schema::table('payroll_vacation_policies', function (Blueprint $table) {
                if (Schema::hasColumn('payroll_vacation_policies', 'end_date')) {
                    $table->date('end_date')->nullable()
                          ->comment('Fecha de fin de aplicación de la política vacacional')->change();
                };

                if (!Schema::hasColumn('payroll_vacation_policies', 'payroll_payment_type_id')) {
                    $table->foreignId('payroll_payment_type_id')->nullable()
                          ->comment('Identificador único asociado al tipo de pago de nómina')
                          ->constrained()->onDelete('restrict')->onUpdate('cascade');
                };
                if (!Schema::hasColumn('payroll_vacation_policies', 'active')) {
                    $table->boolean('active')->default(false)
                          ->comment('Indica si la política vacacional está activa');
                };
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
        if (Schema::hasTable('payroll_vacation_policies')) {
            Schema::table('payroll_vacation_policies', function (Blueprint $table) {
                if (Schema::hasColumn('payroll_vacation_policies', 'end_date')) {
                    $table->date('end_date')->comment('Fecha de fin de aplicación de la política vacacional')->change();
                };

                if (Schema::hasColumn('payroll_vacation_policies', 'payroll_payment_type_id')) {
                    $table->dropForeign(['payroll_payment_type_id']);
                    $table->dropColumn('payroll_payment_type_id');
                };

                if (Schema::hasColumn('payroll_vacation_policies', 'active')) {
                    $table->dropColumn('active');
                };
            });
        };
    }
}
