<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_organizations')) {
            Schema::create('payroll_organizations', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 100)->comment('Nombre de la organización');
                $table->date('start_date')->comment('Fecha de ingreso');
                $table->date('end_date')->comment('Fecha de egreso');

                $table->integer('payroll_sector_type_id')->unsigned()
                      ->comment('identificador del tipo de sector que pertenece a la organización');
                $table->foreign('payroll_sector_type_id')->references('id')->on('payroll_sector_types')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('payroll_employment_information_id')->unsigned()
                      ->comment('identificador de la información laboral que pertenece a la organización');
                $table->foreign('payroll_employment_information_id')->references('id')->on('payroll_employment_informations')
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
        Schema::dropIfExists('payroll_organizations');
    }
}
