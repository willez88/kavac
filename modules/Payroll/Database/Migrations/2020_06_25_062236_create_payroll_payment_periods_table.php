<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      CreatePayrollPaymentPeriodsTable
 * @brief      Crear tabla de períodos de pago de nómina
 *
 * Gestiona la creación o eliminación de la tabla períodos de pago de nómina
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePayrollPaymentPeriodsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_payment_periods')) {
            Schema::create('payroll_payment_periods', function (Blueprint $table) {
                $table->id()->comment('Identificador único del registro');

                $table->unsignedInteger('number')->comment('Número del período de pago');
                $table->date('start_date')->comment('Fecha de inicio del período de pago');
                $table->string('start_day', 20)->comment('Día asociado a la fecha de inicio del período');
                $table->date('end_date')->comment('Fecha de fin del período de pago');
                $table->string('end_day', 20)->comment('Día asociado a la fecha de fin del período');

                $table->enum('payment_status', ['pending', 'generated'])->default('pending')
                      ->comment('Establece la condición del pago asociado al período ' .
                                                '(pending: Pendiente, generated: Generado)');

                $table->foreignId('payroll_payment_type_id')
                      ->comment('Identificador único asociado al tipo de pago de nómina')
                      ->constrained()->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('payroll_payment_periods');
    }
}
