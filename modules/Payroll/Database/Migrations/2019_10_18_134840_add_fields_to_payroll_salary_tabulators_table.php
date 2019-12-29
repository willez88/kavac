<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldsToPayrollSalaryTabulatorsTable
 * @brief Agrega nuevos campos a la tabla de tabuladores salariales
 *
 * Gestiona la creación o eliminación de nuevos campos de la tabla de tabuladores salariales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldsToPayrollSalaryTabulatorsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('payroll_salary_tabulators')) {
            Schema::table('payroll_salary_tabulators', function (Blueprint $table) {
                if (!Schema::hasColumn('payroll_salary_tabulators', 'code')) {
                    $table->string('code')->nullable()->unique()
                          ->comment('Código asociado al tabulador');
                }

                if (!Schema::hasColumn('payroll_salary_tabulators', 'institution_id')) {
                    $table->bigInteger('institution_id')->unsigned()->nullable()
                          ->comment('Identificador único de la institución asociada al tabulador');
                    $table->foreign('institution_id')
                          ->references('id')->on('institutions')
                          ->onDelete('restrict')->onUpdate('cascade');
                }

                if (!Schema::hasColumn('payroll_salary_tabulators', 'currency_id')) {
                    $table->bigInteger('currency_id')->unsigned()->nullable()
                          ->comment('Identificador único de la moneda asociada al tabulador');
                    $table->foreign('currency_id')
                          ->references('id')->on('currencies')
                          ->onDelete('restrict')->onUpdate('cascade');
                }

                if (Schema::hasColumn('payroll_salary_tabulators', 'payroll_position_type_id')) {
                    $table->dropForeign(['payroll_position_type_id']);
                    $table->dropColumn('payroll_position_type_id');
                }

                if (!Schema::hasColumn('payroll_salary_tabulators', 'payroll_staff_type_id')) {
                    $table->bigInteger('payroll_staff_type_id')->unsigned()->nullable()
                          ->comment('Identificador único del tipo de personal al que se aplica el tabulador salarial');
                    $table->foreign('payroll_staff_type_id')->references('id')->on('payroll_staff_types')
                          ->onDelete('restrict')->onUpdate('cascade');
                }
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_salary_tabulators', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_salary_tabulators', 'code')) {
                $table->dropUnique(['code']);
                $table->dropColumn('code');
            }
            if (Schema::hasColumn('payroll_salary_tabulators', 'institution_id')) {
                $table->dropForeign(['institution_id']);
                $table->dropColumn('institution_id');
            }

            if (Schema::hasColumn('payroll_salary_tabulators', 'currency_id')) {
                $table->dropForeign(['currency_id']);
                $table->dropColumn('currency_id');
            }

            if (Schema::hasColumn('payroll_salary_tabulators', 'payroll_staff_type_id')) {
                $table->dropForeign(['payroll_staff_type_id']);
                $table->dropColumn('payroll_staff_type_id');
            }

            if (!Schema::hasColumn('payroll_salary_tabulators', 'payroll_position_type_id')) {
                $table->bigInteger('payroll_position_type_id')->unsigned()->nullable()
                      ->comment('Identificador único del tipo de cargo al que se aplica el tabulador salarial');
                $table->foreign('payroll_position_type_id')->references('id')->on('payroll_position_types')
                      ->onDelete('restrict')->onUpdate('cascade');
            }
        });
    }
}
