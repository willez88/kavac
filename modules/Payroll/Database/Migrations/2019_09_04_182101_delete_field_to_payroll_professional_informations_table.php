<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class DeleteFieldToPayrollProfessionalInformationsTable
 * @brief Elimina el campo profesión de la tabla de informaciones profesionales del trabajador
 *
 * Gestiona la eliminación de un campo en la tabla de informaciones profesionales del trabajador
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class DeleteFieldToPayrollProfessionalInformationsTable extends Migration
{
    /**
     * Método que elimina el campo profession_id de la tabla
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('payroll_professional_informations', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_professional_informations', 'profession_id')) {
                $table->dropForeign('payroll_professional_informations_profession_id_foreign');
                $table->dropColumn('profession_id');
            }
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Método que agrega el campo profession_id a la tabla
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_professional_informations', function (Blueprint $table) {
            $table->foreignId('profession_id')->nullable()->constrained()->onDelete('restrict')->onUpdate('cascade');
        });
    }
}
