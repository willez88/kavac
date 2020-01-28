<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollConceptTypesTable
 * @brief Crear tabla de tipos de concepto
 *
 * Gestiona la creación o eliminación de la tabla de tipos de concepto
 *
 * @author William Páez <wpaez at cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreatePayrollConceptTypesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author William Páez <wpaez at cenditel.gob.ve>
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_concept_types')) {
            Schema::create('payroll_concept_types', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 100)->comment('Nombre del tipo de concepto');
                $table->string('description', 200)->nullable()->comment('Descripción del tipo de concepto');
                $table->string('sign', 1)->comment('Signo para el tipo de concepto');
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
        Schema::dropIfExists('payroll_concept_types');
    }
}
