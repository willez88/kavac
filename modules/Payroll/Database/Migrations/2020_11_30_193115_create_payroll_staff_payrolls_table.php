<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      CreatePayrollStaffPayrollsTable
 * @brief      Crear la tabla intermedia del personal y los registros de la nómina de sueldos
 *
 * Gestiona la creación o eliminación de la intermedia del personal y los registros de la nómina de sueldos
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePayrollStaffPayrollsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_staff_payrolls')) {
            Schema::create('payroll_staff_payrolls', function (Blueprint $table) {
                $table->id()->comment('Identificador único del registro');

                $table->text('assignments')->nullable()
                      ->comment('Conjunto de [nombre - valor] de los conceptos establecidos como ' .
                                'ingresos adicionales al salario');
                $table->text('deductions')->nullable()
                      ->comment('Conjunto de [nombre - valor] de los conceptos establecidos como ' .
                                'descuentos al salario');

                $table->foreignId('payroll_id')
                      ->comment('Identificador único asociado a los registros de nómina')
                      ->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->foreignId('payroll_staff_id')
                      ->comment('Identificador único asociado al trabajador')
                      ->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
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
        Schema::dropIfExists('payroll_staff_payrolls');
    }
}
