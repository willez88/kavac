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
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
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

            $table->bigInteger('payroll_concept_type_id')->unsigned()->nullable()
                  ->comment('Identificador único del tipo de concepto asociado al concepto');
            $table->foreign('payroll_concept_type_id')
                  ->references('id')->on('payroll_concept_types')
                  ->onDelete('restrict')->onUpdate('cascade');

            $table->bigInteger('institution_id')->unsigned()->nullable()
                  ->comment('Identificador único de la institución asociada al concepto');
            $table->foreign('institution_id')
                  ->references('id')->on('institutions')
                  ->onDelete('restrict')->onUpdate('cascade');
            
            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
        });
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
