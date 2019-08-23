<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollEmploymentInformationsTable
 * @brief Crear tabla de la información laboral del trabajador
 *
 * Gestiona la creación o eliminación de la tabla de información laboral del trabajador
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreatePayrollEmploymentInformationsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_employment_informations')) {
            Schema::create('payroll_employment_informations', function (Blueprint $table) {
                $table->increments('id');
                $table->boolean('active')->default(true)->comment('Indica si el trabajador está activo');
                $table->date('start_date_apn')->comment('Fecha de ingreso a la administración pública nacional');
                $table->date('start_date')->comment('Fecha de ingreso a la institución');
                $table->date('end_date')->nullable()->comment('Fecha de egreso de la institución');
                $table->string('institution_email', 100)
                      ->unique()->nullable()->comment('Correo electrónico institucional');
                $table->text('function_description')->nullable()->comment('Descripción de funciones');

                $table->integer('payroll_inactivity_type_id')->unsigned()->nullable()
                      ->comment('identificador del tipo de inactividad que pertenece a la información laboral');
                $table->foreign('payroll_inactivity_type_id')->references('id')->on('payroll_inactivity_types')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('payroll_position_type_id')->unsigned()
                      ->comment('identificador del tipo de cargo que pertenece a la información laboral');
                $table->foreign('payroll_position_type_id')->references('id')->on('payroll_position_types')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('payroll_position_id')->unsigned()
                      ->comment('identificador del cargo que pertenece a la información laboral');
                $table->foreign('payroll_position_id')->references('id')->on('payroll_positions')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('payroll_staff_type_id')->unsigned()
                      ->comment('identificador del tipo de personal que pertenece a la información laboral');
                $table->foreign('payroll_staff_type_id')->references('id')->on('payroll_staff_types')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('department_id')->unsigned()
                      ->comment('identificador del departamento que pertenece a la información laboral');
                $table->foreign('department_id')->references('id')->on('departments')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('payroll_contract_type_id')->unsigned()
                      ->comment('identificador del tipo de contrato que pertenece a la información laboral');
                $table->foreign('payroll_contract_type_id')->references('id')->on('payroll_contract_types')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('payroll_staff_id')->unsigned()->unique()
                      ->comment('identificador del personal que pertenece a la información laboral');
                $table->foreign('payroll_staff_id')->references('id')->on('payroll_staffs')
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
        Schema::dropIfExists('payroll_employment_informations');
    }
}
