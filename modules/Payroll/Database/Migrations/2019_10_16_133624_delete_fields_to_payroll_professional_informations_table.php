<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class DeleteFieldsToPayrollProfessionalInformationsTable
 * @brief Elimina los campos idioma y nivel de idioma de la tabla de informaciones profesionales del trabajador
 *
 * Gestiona la eliminación de un campo en la tabla de informaciones profesionales del trabajador
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class DeleteFieldsToPayrollProfessionalInformationsTable extends Migration
{
    /**
     * Método que elimina el campo payroll_language_id y payroll_language_level_id de la tabla
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_professional_informations', function (Blueprint $table) {
            $table->dropForeign('payroll_professional_informations_payroll_language_id_foreign');
            $table->dropColumn('payroll_language_id');
            $table->dropForeign('payroll_professional_informations_language_level_pk');
            $table->dropColumn('payroll_language_level_id');
        });
    }

    /**
     * Método que agrega el campo payroll_language_id y payroll_language_level_id a la tabla
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_professional_informations', function (Blueprint $table) {
            $table->bigInteger('payroll_language_id')->unsigned()->nullable()
                  ->comment('identificador del idioma que pertenecen a la información profesional');
            $table->foreign('payroll_language_id')->references('id')->on('payroll_languages')
                  ->onDelete('restrict')->onUpdate('cascade');

            $table->bigInteger('payroll_language_level_id')->unsigned()->nullable()
                  ->comment('identificador del mivel de idioma que pertenecen a la información profesional');
            $table->foreign('payroll_language_level_id')->references('id')->on('payroll_language_levels')
                  ->onDelete('restrict')->onUpdate('cascade');
        });
    }
}
