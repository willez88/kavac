<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollInstructionDegreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_instruction_degrees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->comment('Nombre del grado de instrucción');
            $table->string('description', 200)->comment('Descripción del grado de instrucción');
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
        Schema::dropIfExists('payroll_instruction_degrees');
    }
}
