<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      CreatePayrollConceptsTable
 * @brief      Crea la tabla de conceptos
 *
 * Gestiona la creación o eliminación de la tabla conceptos
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePayrollConceptsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_concepts')) {
            Schema::create('payroll_concepts', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');
                $table->string('code')->comment('Código del concepto');
                $table->string('name')->comment('Nombre del concepto');
                $table->string('description')->nullable()->comment('Descripción del concepto');
                $table->boolean('active')->default(true)->comment('Indica si el concepto esta activo');
                $table->enum('incidence_type', ['value', 'absolute_value', 'tax_unit', 'percent'])
                      ->comment('Tipo de incidencia del concepto: valor, ' .
                        'valor absoluto, unidad tributaria o porcentaje');
                $table->enum('affect', ['base_salary', 'normal_salary', 'dialy_salary', 'comprehensive_salary'])
                      ->comment('Incide sobre: salario base, salario normal, ' .
                        'salario diario, salario integral');

                $table->foreignId('payroll_concept_type_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->foreignId('institution_id')->nullable()->constrained()
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
        Schema::dropIfExists('payroll_concepts');
    }
}
