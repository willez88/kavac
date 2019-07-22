<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetsAsignationTable
 * @brief Crear tabla asignación de bienes
 * 
 * Gestiona la creación o eliminación de las asignaciones de los bienes Institucionales
 * 
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class CreateAssetAsignationsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_asignations')) {
            Schema::create('asset_asignations', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('code', 20)->unique()->comment('Código identificador de la asignación');

                $table->integer('payroll_staff_id')->nullable()->unsigned()
                      ->comment('Identificador único del trabajador responsable del bien');
                $table->foreign('payroll_staff_id')->references('id')->on('payroll_staffs');
                
                $table->integer('department_id')->nullable()->unsigned()->comment('Identificador único del departamento donde recide el bien mueble');
                $table->foreign('department_id')->references('id')->on('departments')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('user_id')->comment('Identificador único del usuario que realiza la asignación');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

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
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_asignations');
    }
}
