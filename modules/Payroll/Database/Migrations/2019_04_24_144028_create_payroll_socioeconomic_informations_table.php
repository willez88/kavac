<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollSocioeconomicInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_socioeconomic_informations')) {
            Schema::create('payroll_socioeconomic_informations', function (Blueprint $table) {
                $table->increments('id');
                $table->string('first_name_twosome', 100)->nullable()->comment('Nombre de la pareja del trabajador');
                $table->string('last_name_twosome', 100)->nullable()->comment('Apellido de la pareja del trabajador');
                $table->string('id_number_twosome', 12)->nullable()->comment('Apellido de la pareja del trabajador');
                $table->date('birthdate_twosome')->nullable()->comment('Fecha de nacimiento de la pareja del trabajador');
                $table->integer('payroll_staff_id')->unsigned()
                      ->comment('identificador del personal que pertenece al dato socioeconómico');
                $table->foreign('payroll_staff_id')->references('id')->on('payroll_staffs')
                      ->onDelete('restrict')->onUpdate('cascade');
                $table->integer('marital_status_id')->unsigned()
                      ->comment('identificador del estado civil que pertenece al dato socioeconómico');
                $table->foreign('marital_status_id')->references('id')->on('marital_status')
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
        Schema::dropIfExists('payroll_socioeconomic_informations');
    }
}
