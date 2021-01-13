<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      CreatePayrollConceptPaymentTypeTable
 * @brief      Crear tabla intermedia entre conceptos y tipos de pago de nómina
 *
 * Gestiona la creación o eliminación de la tabla intermedia entre conceptos y tipos de pago de nómina
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePayrollConceptPaymentTypeTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_concept_payment_type')) {
            Schema::create('payroll_concept_payment_type', function (Blueprint $table) {
                $table->id()->comment('Identificador único del registro');

                $table->foreignId('payroll_concept_id')->comment('Identificador único asociado al concepto')
                      ->constrained()->onDelete('restrict')->onUpdate('cascade');
                $table->foreignId('payroll_payment_type_id')->comment('Identificador único asociado al tipo de pago')
                      ->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
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
        Schema::dropIfExists('payroll_concept_payment_type');
    }
}
