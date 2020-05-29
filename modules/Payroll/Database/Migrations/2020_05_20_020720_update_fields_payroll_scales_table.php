<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldsPayrollScalesTable
 * @brief Actualiza los campos de la tabla de escalas o niveles
 *
 * Gestiona la creación o eliminación de los campos de la tabla de escalas o niveles
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class UpdateFieldsPayrollScalesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_scales', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_scales', 'code')) {
                $table->dropColumn('code');
            }
            if (Schema::hasColumn('payroll_scales', 'description')) {
                $table->dropColumn('description');
            }
            if (!Schema::hasColumn('payroll_scales', 'value')) {
                $table->text('value')->nullable()->comment('Valor establecido para la escala');
            }

        });
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_scales', function (Blueprint $table) {
            if (!Schema::hasColumn('payroll_scales', 'code')) {
                $table->string('code', 5)->nullable()->comment('Código de la escala o nivel');
            }
            if (!Schema::hasColumn('payroll_scales', 'description')) {
                $table->text('description')->nullable()->comment('Descripción de la escala o nivel');
            }
            if (Schema::hasColumn('payroll_scales', 'value')) {
                $table->dropColumn('value');
            }

        });
    }
}
