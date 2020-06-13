<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollStaffsTable
 * @brief Crear tabla de la información personal del trabajador
 *
 * Gestiona la creación o eliminación de la tabla de información personal del trabajador
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreatePayrollStaffsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_staffs')) {
            Schema::create('payroll_staffs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('code', 20)->unique()->comment('Código identificador del personal');
                $table->string('first_name', 100)->comment('Nombres del personal');
                $table->string('last_name', 100)->comment('Apellidos del personal');
                $table->date('birthdate')->comment('Fecha de nacimiento del personal');
                $table->string('email')->unique()->nullable()->comment('Correo electrónico del personal');
                $table->string('id_number', 12)->unique()->comment('Cédula de identidad del personal');
                $table->string('passport', 20)->unique()->nullable()->comment('Número de pasaporte del personal');
                $table->string('emergency_contact', 200)->nullable()
                      ->comment('Nombre y apellido del contacto de emergencia');
                $table->string('emergency_phone', 20)->nullable()->comment('Teléfono del contacto de emergencia');
                $table->string('address', 200)->comment('Dirección de habitación del personal');
                $table->foreignId('parish_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('payroll_staffs');
    }
}
