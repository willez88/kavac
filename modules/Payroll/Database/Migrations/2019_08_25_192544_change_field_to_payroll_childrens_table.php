<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class ChangeFieldToPayrollChildrensTable
 * @brief Altera campos en la tabla de hijos del trabajador
 *
 * Gestiona cambios en la tabla hijos del trabajador
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class ChangeFieldToPayrollChildrensTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_childrens', function (Blueprint $table) {
            $table->string('id_number', 12)->nullable()
                  ->unique()->comment('Cédula del hijo del trabajador')->change();
        });
    }

    /**
     * Método que elimina las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_childrens', function (Blueprint $table) {
            $table->dropUnique(['id_number']);
            $table->string('id_number', 12)->nullable()->comment('cédula de la pareja del trabajador')->change();
        });
    }
}
