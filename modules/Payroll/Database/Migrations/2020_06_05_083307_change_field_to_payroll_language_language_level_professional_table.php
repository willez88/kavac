<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class ChangeFieldToPayrollLanguageLanguageLevelProfessionalTable
 * @brief Altera campos en la tabla payroll_language_language_level_professional
 *
 * Gestiona cambios en la tabla payroll_language_language_level_professional
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class ChangeFieldToPayrollLanguageLanguageLevelProfessionalTable extends Migration
{
    /**
     * Método que elimina el campo payroll_professional_information_id y agrega payroll_professional_id a la tabla
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_language_language_level_professional', function (Blueprint $table) {
            if (Schema::hasColumn(
                'payroll_language_language_level_professional',
                'payroll_professional_information_id'
            )
            ) {
                $table->dropUnique(['payroll_language_id', 'payroll_professional_information_id']);
                $table->dropColumn(['payroll_professional_information_id']);
            }

            if (!Schema::hasColumn('payroll_language_language_level_professional', 'payroll_professional_id')) {
                $table->bigInteger('payroll_professional_id')->unsigned()->nullable()
                      ->comment('Identificador profesional del trabajador');
                $table->foreign('payroll_professional_id')->references('id')
                      ->on('payroll_professionals')->onDelete('restrict')->onUpdate('cascade');
            }

            $table->unique(['payroll_language_id', 'payroll_professional_id',])
                  ->comment('Clave única para el registro');
        });
    }

    /**
     * Método que elimina el campo payroll_professional_id y agrega payroll_professional_information_id a la tabla
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_language_language_level_professional', function (Blueprint $table) {
            if (Schema::hasColumn(
                'payroll_language_language_level_professional',
                'payroll_professional_id'
            )
            ) {
                $table->dropUnique(['payroll_language_id', 'payroll_professional_id']);
                $table->dropColumn(['payroll_professional_id']);
            }

            if (!Schema::hasColumn(
                'payroll_language_language_level_professional',
                'payroll_professional_information_id'
            )
            ) {
                $table->bigInteger('payroll_professional_information_id')->unsigned()->nullable()
                      ->comment('Identificador profesional del trabajador');
                $table->foreign('payroll_professional_information_id')->references('id')
                      ->on('payroll_professional_informations')->onDelete('restrict')->onUpdate('cascade');
            }

            $table->unique(['payroll_language_id', 'payroll_professional_information_id',])
                  ->comment('Clave única para el registro');
        });
    }
}
