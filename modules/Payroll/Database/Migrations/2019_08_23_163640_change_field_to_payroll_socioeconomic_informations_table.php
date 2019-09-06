<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class ChangeFieldToPayrollSocioeconomicInformationsTable
 * @brief Altera campos en la tabla de información socioeconómica del trabajador
 *
 * Gestiona cambios en la tabla de información socioeconómica del trabajador
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class ChangeFieldToPayrollSocioeconomicInformationsTable extends Migration
{
    /**
     * Método que agrega el atributo único al campo id_number_twosome
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_socioeconomic_informations', function (Blueprint $table) {
            $table->string('id_number_twosome', 12)
                  ->nullable()->unique()->comment('cédula de la pareja del trabajador')->change();
        });
    }

    /**
     * Método que elimina el atributo único al campo id_number_twosome
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_socioeconomic_informations', function (Blueprint $table) {
            $table->dropUnique(['id_number_twosome']);
            $table->string('id_number_twosome', 12)->nullable()->comment('cédula de la pareja del trabajador')
                  ->change();
        });
    }
}
