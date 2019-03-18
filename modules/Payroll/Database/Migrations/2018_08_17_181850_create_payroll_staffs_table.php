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
                $table->string('sex', 1)->comment('Sexo del personal');
                $table->string('email')->unique()->nullable()->comment('Correo electrónico del personal');
                $table->boolean('active')->default(True)->comment('Estatus del personal');
                $table->string('website', 255)->nullable()->comment('Sitio web del personal');
                $table->string('direction')->comment('Dirección del personal');
                $table->integer('sons')->comment('Número de hijos que tiene el personal');
                $table->date('start_date_public_adm')->comment('Fecha de inicio en la administración pública');
                $table->date('start_date')->comment('Fecha de inicio a la institución');
                $table->date('end_date')->nullable()->comment('fecha de egreso de la institución');
                $table->string('id_number', 12)->unique()->comment('Cédula de identidad del personal');
                $table->string('passport', 20)->unique()->nullable()->comment('Número de pasaporte del personal');
                $table->integer('marital_status_id')->unsigned()
                      ->comment('identificador del estado civil al que pertenece el personal');
                $table->foreign('marital_status_id')->references('id')->on('marital_status')
                      ->onDelete('restrict')->onUpdate('cascade');
                $table->integer('profession_id')->unsigned()
                      ->comment('identificador de la profesión al que pertenece el personal');
                $table->foreign('profession_id')->references('id')->on('professions')
                      ->onDelete('restrict')->onUpdate('cascade');
                $table->integer('city_id')->unsigned()
                      ->comment('identificador de la ciudad al que pertenece el personal');
                $table->foreign('city_id')->references('id')->on('cities')
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
