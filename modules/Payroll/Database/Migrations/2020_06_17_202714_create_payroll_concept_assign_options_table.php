<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      CreatePayrollConceptAssignOptionsTable
 * @brief      Crear tabla opciones de asignación de conceptos
 *
 * Gestiona la creación o eliminación de la tabla opciones de asignación de conceptos
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePayrollConceptAssignOptionsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_concept_assign_options')) {
            Schema::create('payroll_concept_assign_options', function (Blueprint $table) {
                $table->id()->comment('Identificador único del registro');

                $table->foreignId('payroll_concept_id')->comment('Identificador único asociado al concepto')
                      ->constrained()->onDelete('restrict')->onUpdate('cascade');
                $table->nullableMorphs('assignable', 'payroll_concept_assign_options_assignable_morphs_index');
                $table->string('key')->comment('Clave de referencia para asignar el concepto');
                $table->string('value')->nullable()->comment('Valor establecido para asignar concepto');

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
        Schema::dropIfExists('payroll_concept_assign_options');
    }
}
