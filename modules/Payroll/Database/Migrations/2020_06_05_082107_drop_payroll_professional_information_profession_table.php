<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class DropPayrollProfessionalInformationProfessionTable
 * @brief Elimina la tabla payroll_professional_information_profession
 *
 * Gestiona la creación o eliminación de la tabla
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class DropPayrollProfessionalInformationProfessionTable extends Migration
{
    /**
     * Método que elimina la tabla payroll_professional_information_profession
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('payroll_professional_information_profession');
    }

    /**
     * Método que crea la tabla payroll_professional_information_profession
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('payroll_professional_information_profession')) {
            Schema::create('payroll_professional_information_profession', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->unsignedBigInteger('payroll_professional_information_id');
                $table->foreign(
                    'payroll_professional_information_id',
                    'payroll_professional_information_profession_professional_fk'
                )->references('id')->on('payroll_professional_informations')->onDelete('cascade');


                $table->foreignId('profession_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }
    }
}
