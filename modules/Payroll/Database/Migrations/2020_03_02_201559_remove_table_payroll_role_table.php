<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class RemoveTablePayrollRoleTable
 * @brief Elimina la tabla rol de la base de datos
 *
 * Gestiona la eliminación de la tabla rol
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class RemoveTablePayrollRoleTable extends Migration
{
    /**
     * Método que elimina la tabla payroll_roles
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('payroll_roles');
    }

    /**
     * Método que agrega la tabla payroll_roles
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('payroll_roles')) {
            Schema::create('payroll_roles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 50)->comment('Nombre del rol del trabajador');
                $table->string('description', 100)->comment('Descripción del rol del trabajador');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }
}
