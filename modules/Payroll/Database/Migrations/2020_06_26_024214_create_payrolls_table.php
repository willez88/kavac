<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      CreatePayrollsTable
 * @brief      Crear tabla de registros de nómina de sueldos
 *
 * Gestiona la creación o eliminación de la tabla de registros de nómina de sueldos
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePayrollsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (!Schema::hasTable('payrolls')) {
            Schema::create('payrolls', function (Blueprint $table) {
                $table->id()->comment('Identificador único del registro');
                $table->string('name')
                      ->comment('Nombre o descripción asociado al registro de nómina');
                $table->string('payroll_parameters')->nullable()
                      ->comment('Valor establecido para los parámetros de nómina');

                $table->foreignId('payroll_payment_period_id')
                      ->comment('Identificador único asociado al período de pago')
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
        Schema::dropIfExists('payrolls');
    }
}
