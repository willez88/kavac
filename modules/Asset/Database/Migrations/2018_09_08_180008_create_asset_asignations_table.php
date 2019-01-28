<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetsAsignationTable
 * @brief Crear tabla Asignación de Bienes
 * 
 * Gestiona la creación o eliminación de las Asignaciones de los Bienes Institucionales
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class CreateAssetAsignationsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_asignations')) {
            Schema::create('asset_asignations', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->integer('staff_id')->nullable()->unsigned()
                      ->comment('Identificador único del trabajador responsable del bien');
                /**
                 * $table->foreign('staff_id')->references('id')->on('payroll_staffs');
                 */

                /**
                 * Fecha en la que se realiza la asignación
                **/
                $table->timestamps();

                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_asignations');
    }
}
