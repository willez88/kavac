<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_staffs')) {
            Schema::create('payroll_staffs', function (Blueprint $table) {
                $table->increments('id');
                $table->string('code', 20)->unique()->comment('Código identificador del personal');
                $table->string('first_name', 100)->comment('Nombres del personal');
                $table->string('last_name', 100)->comment('Apellidos del personal');
                $table->date('birthdate')->comment('Fecha de nacimiento del personal');
                $table->string('email')->unique()->nullable()->comment('Correo electrónico del personal');
                $table->string('id_number', 12)->unique()->comment('Cédula de identidad del personal');
                $table->string('passport', 20)->unique()->nullable()->comment('Número de pasaporte del personal');
                $table->string('emergency_contact', 200)->nullable()->comment('Nombre y apellido del contacto de emergencia');
                $table->string('emergency_phone', 20)->nullable()->comment('Teléfono del contacto de emergencia');
                $table->string('address', 200)->comment('Dirección de habitación del personal');
                $table->integer('parish_id')->unsigned()
                      ->comment('identificador de la parroquia al que pertenece el personal');
                $table->foreign('parish_id')->references('id')->on('parishes')
                      ->onDelete('restrict')->onUpdate('cascade');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_staffs');
    }
}
