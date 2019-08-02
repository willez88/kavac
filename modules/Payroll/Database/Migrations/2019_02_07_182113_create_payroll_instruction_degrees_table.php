<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollInstructionDegreesTable
 * @brief Crear tabla de grado de instrucción
 *
 * Gestiona la creación o eliminación de la tabla de grados de instrucción
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class CreatePayrollInstructionDegreesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_instruction_degree')) {
            Schema::create('payroll_instruction_degrees', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 100)->comment('Nombre del grado de instrucción');
                $table->string('description', 200)->nullable()->comment('Descripción del grado de instrucción');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
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
        Schema::dropIfExists('payroll_instruction_degrees');
    }
}
