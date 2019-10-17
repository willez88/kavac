<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollLanguagePayrollProfessionalTable
 * @brief Crear tabla intermedia entre idioma y la información profesional
 *
 * Gestiona la creación o eliminación de la tabla intermedia entre idioma y la información profesional
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreatePayrollLanguagePayrollProfessionalTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_language_payroll_professional')) {
            Schema::create('payroll_language_payroll_professional', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->integer('payroll_language_id')->unsigned()->index();
                $table->foreign('payroll_language_id')->references('id')->on('payroll_languages')->onDelete('cascade');

                $table->integer('payroll_professional_information_id')->unsigned()->index();
                $table->foreign('payroll_professional_information_id')
                      ->references('id')->on('payroll_professional_informations')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::drop('payroll_language_payroll_professional');
    }
}
