<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class DropPayrollSocioeconomicInformationsTable
 * @brief Elimina la tabla payroll_socioeconomic_informations
 *
 * Gestiona la creación o eliminación de la tabla
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class DropPayrollSocioeconomicInformationsTable extends Migration
{
    /**
     * Método que elimina la tabla payroll_socioeconomic_informations
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_socioeconomic_informations', function (Blueprint $table) {
            $foreignKeys = list_table_foreign_keys('payroll_socioeconomic_informations');
            if (in_array('payroll_childrens_payroll_socioeconomic_information_id_foreign', $foreignKeys)) {
                $table->dropForeign('payroll_childrens_payroll_socioeconomic_information_id_foreign');
            }
        });
        Schema::dropIfExists('payroll_socioeconomic_informations');
    }

    /**
     * Método que crea la tabla payroll_socioeconomic_informations
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('payroll_socioeconomic_informations')) {
            Schema::create('payroll_socioeconomic_informations', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('full_name_twosome', 200)->nullable()
                      ->comment('Nombres y apellidos de la pareja del trabajador');
                $table->string('id_number_twosome', 12)->unique()->nullable()
                      ->comment('cédula de la pareja del trabajador');
                $table->date('birthdate_twosome')->nullable()
                      ->comment('Fecha de nacimiento de la pareja del trabajador');

                $table->foreignId('payroll_staff_id')->unique()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->foreignId('marital_status_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }
}
