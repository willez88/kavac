<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollAssignmentTypesTable
 * @brief Crear tabla de tipos de asignaciones de nómina
 *
 * Gestiona la creación o eliminación de la tabla de tipos de asignaciones de nómina
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class CreatePayrollAssignmentTypesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_assignment_types')) {
            Schema::create('payroll_assignment_types', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('name')->comment('Nombre del tipo de asignación de nómina');
                $table->string('description')->nullable()->comment('Descripción del tipo de asignación de nómina');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     */
    public function down()
    {
        Schema::dropIfExists('payroll_assignment_types');
    }
}
