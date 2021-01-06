<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      CreatePayrollVacationPoliciesTable
 * @brief      Crear tabla de políticas vacacionales
 *
 * Gestiona la creación o eliminación de la tabla de políticas vacacionales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePayrollVacationPoliciesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_vacation_policies')) {
            Schema::create('payroll_vacation_policies', function (Blueprint $table) {
                $table->id()->comment('Identificador único del registro');
                $table->string('name')->comment('Nombre o descripción asociado a la política vacacional');
                $table->date('start_date')->comment('Fecha de inicio de aplicación de la política vacacional');
                $table->date('end_date')->comment('Fecha de fin de aplicación de la política vacacional');
                $table->string('vacation_periods')
                      ->comment('Establece los períodos vacaciones, si aplica: [{start_date, end_date}]');
                $table->enum('vacation_type', ['collective_vacations', 'vacation_period'])
                      ->comment('Establece el tipo de vacaciones ' .
                                '(collective_vacations: Colectivas, vacation_period: Por período)');
                $table->enum(
                    'salary_type',
                    ['base_salary', 'comprehensive_salary', 'normal_salary', 'dialy_salary']
                )->comment('Establece el salario a emplear para el cálculo del bono vacacional ' .
                           '(base_salary: Salario base, comprehensive_salary: Salario integral,' .
                           ' normal_salary: Salario normal, dialy_salary: Salario diario)');
                $table->enum('payment_calculation', ['enjoyment_days', 'general_days'])
                      ->comment('Establece el pago de acuerdo a: ' .
                                '(enjoyment_days: Días de disfrute, general_days: Días generales)');
                $table->boolean('vacation_advance')->default(false)
                      ->comment('Establece si se habilita el adelanto del disfrute de vacaciones');
                $table->boolean('vacation_postpone')->default(false)
                      ->comment('Establece si se habilita el postergue del disfrute de vacaciones');
                $table->boolean('staff_antiquity')->default(false)
                      ->comment('Establece si se habilita el pago del bono vacacional de acuerdo ' .
                                'a la antiguedad del trabajador');

                $table->unsignedInteger('vacation_periods_accumulated_per_year')->nullable()
                      ->comment('Períodos vacacionales acumulados permitidos por año');
                $table->unsignedInteger('vacation_days')->nullable()
                      ->comment('Días a otorgar para el pago de vacaciones');
                $table->unsignedInteger('vacation_period_per_year')->nullable()
                      ->comment('Períodos vacacionales permitidos por año');
                $table->unsignedInteger('additional_days_per_year')->nullable()
                      ->comment('Días adicionales a otorgar para el pago de vacaciones por año de servicio');
                $table->unsignedInteger('minimum_additional_days_per_year')->nullable()
                      ->comment('Mínimo de días a otorgar para el pago de vacaciones');
                $table->unsignedInteger('maximum_additional_days_per_year')->nullable()
                      ->comment('Máximo de días a otorgar para el pago de vacaciones');

                $table->foreignId('institution_id')->constrained()
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
        Schema::dropIfExists('payroll_vacation_policies');
    }
}
