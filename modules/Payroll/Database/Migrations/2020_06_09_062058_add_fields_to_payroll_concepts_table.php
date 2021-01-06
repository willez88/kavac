<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      AddFieldsToPayrollConceptsTable
 * @brief      Agrega nuevos campos a la tabla de conceptos
 *
 * Gestiona la creación o eliminación de nuevos campos a la tabla de conceptos
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AddFieldsToPayrollConceptsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (Schema::hasTable('payroll_concepts')) {
            Schema::table('payroll_concepts', function (Blueprint $table) {
                if (!Schema::hasColumn('payroll_concepts', 'accounting_account_id')) {
                    $table->foreignId('accounting_account_id')->nullable()
                          ->comment('Identificador único asociado a la cuenta contable')
                          ->constrained()->onDelete('restrict')->onUpdate('cascade');
                };
                if (!Schema::hasColumn('payroll_concepts', 'budget_account_id')) {
                    $table->foreignId('budget_account_id')->nullable()
                          ->comment('Identificador único asociado a la cuenta presupuestaria')
                          ->constrained()->onDelete('restrict')->onUpdate('cascade');
                };
                if (!Schema::hasColumn('payroll_concepts', 'affect')) {
                    $table->enum('affect', ['base_salary', 'normal_salary', 'dialy_salary', 'comprehensive_salary'])
                          ->nullable()->comment('Salario sobre el cual incide el concepto ' .
                                                '(Salario Base, Salario Normal, Salario Diario, Salario Integral)');
                };
                if (!Schema::hasColumn('payroll_concepts', 'calculation_way')) {
                    $table->enum('calculation_way', ['formula', 'tabulator'])
                          ->nullable()->comment('Forma de cálculo para la incidencia del concepto ' .
                                                '(Según fórmula, De acuerdo a tabulador)');
                };
                if (!Schema::hasColumn('payroll_concepts', 'formula')) {
                    $table->text('formula')->nullable()
                          ->comment('Fórmula empleada para el cálculo de incidencia');
                };
                if (!Schema::hasColumn('payroll_concepts', 'payroll_salary_tabulator_id')) {
                    $table->foreignId('payroll_salary_tabulator_id')->nullable()
                          ->comment('Identificador único asociado al tabulador salarial empleado para ' .
                                    'el cálculo de incidencia')
                          ->constrained()->onDelete('restrict')->onUpdate('cascade');
                };
                if (!Schema::hasColumn('payroll_concepts', 'assign_to')) {
                    $table->longText('assign_to')->nullable()
                          ->comment('Registros de grupo opciones a los que se le asigna el concepto');
                };
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
        if (Schema::hasTable('payroll_concepts')) {
            Schema::table('payroll_concepts', function (Blueprint $table) {
                if (Schema::hasColumn('payroll_concepts', 'accounting_account_id')) {
                    $table->dropForeign(['accounting_account_id']);
                    $table->dropColumn('accounting_account_id');
                };
                if (Schema::hasColumn('payroll_concepts', 'budget_account_id')) {
                    $table->dropForeign(['budget_account_id']);
                    $table->dropColumn('budget_account_id');
                };
                if (Schema::hasColumn('payroll_concepts', 'affect')) {
                    $table->dropColumn('affect');
                };
                if (Schema::hasColumn('payroll_concepts', 'calculation_way')) {
                    $table->dropColumn('calculation_way');
                };
                if (Schema::hasColumn('payroll_concepts', 'formula')) {
                    $table->dropColumn('formula');
                };
                if (Schema::hasColumn('payroll_concepts', 'payroll_salary_tabulator_id')) {
                    $table->dropForeign(['payroll_salary_tabulator_id']);
                    $table->dropColumn('payroll_salary_tabulator_id');
                };
                if (Schema::hasColumn('payroll_concepts', 'assign_to')) {
                    $table->dropColumn('assign_to');
                };
            });
        };
    }
}
