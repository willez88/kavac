<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollChildrensTable
 * @brief Crear tabla de hijos de los trabajadores
 *
 * Gestiona la creación o eliminación de la tabla de hijos de los trabajadores
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreatePayrollChildrensTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_childrens')) {
            Schema::create('payroll_childrens', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('first_name', 100)->comment('Nombre del hijo del trabajador');
                $table->string('last_name', 100)->comment('Apellido del hijo del trabajador');
                $table->string('id_number', 12)->nullable()->comment('Cédula del hijo del trabajador');
                $table->date('birthdate')->comment('Fecha de nacimiento del hijo del trabajador');

                $table->bigInteger('payroll_socioeconomic_information_id')->unsigned()
                      ->comment('identificador de la información socioeconómica que pertenece al hijo');
                $table->foreign('payroll_socioeconomic_information_id')
                      ->references('id')->on('payroll_socioeconomic_informations')
                      ->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('payroll_childrens');
    }
}
