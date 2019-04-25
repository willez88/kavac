<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollChildrensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_childrens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 100)->nullable()->comment('Nombre del hijo del trabajador');
            $table->string('last_name', 100)->nullable()->comment('Apellido del hijo del trabajador');
            $table->string('id_number', 12)->nullable()->comment('Cédula del hijo del trabajador');
            $table->date('birthdate')->nullable()->comment('Fecha de nacimiento del hijo del trabajador');
            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_childrens');
    }
}
