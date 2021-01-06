<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      CreatePayrollBenefitsPoliciesTable
 * @brief      Crear tabla de políticas de prestaciones sociales
 *
 * Gestiona la creación o eliminación de la tabla de políticas de prestaciones sociales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePayrollBenefitsPoliciesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_benefits_policies')) {
            Schema::create('payroll_benefits_policies', function (Blueprint $table) {
                $table->id()->comment('Identificador único del registro');
                $table->string('name')->comment('Nombre o descripción asociado a la política de prestaciones');
                $table->date('start_date')->comment('Fecha de inicio de aplicación de la política de prestaciones');
                $table->date('end_date')->nullable()->comment('Fecha de fin de aplicación de la política prestaciones');

                $table->unsignedInteger('benefit_days')
                      ->comment('Días a cancelar por garantías de prestaciones sociales');
                $table->unsignedInteger('minimum_number_months')
                      ->comment('Número mínimo de meses para el pago de prestaciones sociales');
                $table->unsignedInteger('additional_days_per_year')
                      ->comment('Días adicionales a otorgar para el pago de prestaciones por año de servicio');
                $table->unsignedInteger('minimum_number_years')
                      ->comment('Número mínimo de años para agregar los días adicionales por año de servicio ' .
                        'al pago de prestaciones');
                $table->unsignedInteger('additional_maximum_days_per_year')->nullable()
                      ->comment('Máximo de días adicionales a otorgar para el pago de prestaciones ' .
                                'por año de servicio');
                $table->unsignedInteger('work_interruption_days')
                      ->comment('Días a cancelar por interrupción laboral');
                $table->unsignedInteger('month_worked_days')
                      ->comment('Días a cancelar por mes trabajado');
                $table->boolean('benfits_advance_payment')->default(false)
                      ->comment('Establece si se habilita el anticipo de prestaciones');
                $table->unsignedInteger('maximum_advance_percentage')->nullable()
                      ->comment('Porcentaje máximo permitido para el anticipo de prestaciones');
                $table->unsignedInteger('number_advances_per_year')->nullable()
                      ->comment('Número de anticipos permitidos por año');

                $table->enum(
                    'salary_type',
                    ['base_salary', 'comprehensive_salary', 'normal_salary', 'dialy_salary']
                )->comment('Establece el salario a emplear para el cálculo de prestaciones ' .
                           '(base_salary: Salario base, comprehensive_salary: Salario integral,' .
                           ' normal_salary: Salario normal, dialy_salary: Salario diario)');

                $table->foreignId('institution_id')->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');
                $table->boolean('active')->default(false)
                      ->comment('Indica si la política de prestaciones está activa');

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
        Schema::dropIfExists('payroll_benefits_policies');
    }
}
