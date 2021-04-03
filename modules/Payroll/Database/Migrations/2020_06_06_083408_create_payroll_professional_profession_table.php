<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollProfessionalProfessionTable
 * @brief Crear tabla intermedia entre información profesional y profesión
 *
 * Gestiona la creación o eliminación de la tabla intermedia entre información profesional y profesión
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreatePayrollProfessionalProfessionTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_professional_profession')) {
            Schema::create('payroll_professional_profession', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();

                $table->foreignId('payroll_professional_id')->comment('Identificador del dato profesional')
                      ->constrained()->onUpdate('cascade')->onDelete('restrict');

                $table->foreignId('profession_id')->comment('Identificador de la profesión')
                      ->constrained()->onUpdate('cascade')->onDelete('restrict');

                $table->timestamps();
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
        Schema::dropIfExists('payroll_professional_profession');
    }
}
