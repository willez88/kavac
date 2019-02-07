<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollLaborDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_labor_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payroll_staff_type_id')->unsigned()
                  ->comment('identificador asociado al tipo de personal');
            $table->foreign('payroll_staff_type_id')->references('id')->on('payroll_staff_types')
                  ->onDelete('restrict')->onUpdate('cascade');
            $table->integer('payroll_position_type_id')->unsigned()
                  ->comment('identificador asociado al tipo de cargo');
            $table->foreign('payroll_position_type_id')->references('id')->on('payroll_position_types')
                  ->onDelete('restrict')->onUpdate('cascade');
            $table->integer('payroll_position_id')->unsigned()
                  ->comment('identificador asociado al cargo');
            $table->foreign('payroll_position_id')->references('id')->on('payroll_positions')
                  ->onDelete('restrict')->onUpdate('cascade');
            $table->integer('department_id')->unsigned()
                  ->comment('identificador asociado al departamento');
            $table->foreign('department_id')->references('id')->on('departments')
                  ->onDelete('restrict')->onUpdate('cascade');
            $table->integer('payroll_staff_id')->unsigned()
                  ->comment('identificador asociado al personal');
            $table->foreign('payroll_staff_id')->references('id')->on('payroll_staffs')
                  ->onDelete('restrict')->onUpdate('cascade');
            $table->date('appointment_date')->comment('Fecha de nombramiento');
            $table->date('vigency_date')->comment('Fecha de entrada en vigencia');
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
        Schema::dropIfExists('payroll_labor_data');
    }
}
