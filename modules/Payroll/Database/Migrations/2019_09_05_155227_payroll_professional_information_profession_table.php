<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollProfessionalInformationProfessionTable
 * @brief Crear tabla intermedia entre la información profesional y la profesión
 *
 * Gestiona la creación o eliminación de la tabla intermedia entre información profesional y profesión
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollProfessionalInformationProfessionTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_professional_information_profession')) {
            Schema::create('payroll_professional_information_profession', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->bigInteger('payroll_professional_information_id')->unsigned()->index();
                $table->foreign(
                    'payroll_professional_information_id',
                    'payroll_professional_information_profession_professional_fk'
                )->references('id')->on('payroll_professional_informations')->onDelete('cascade');

                $table->bigInteger('profession_id')->unsigned()->index();
                $table->foreign('profession_id')->references('id')->on('professions')->onDelete('cascade');
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
        Schema::drop('payroll_professional_information_profession');
    }
}
