<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('budget_projects')) {
            Schema::create('budget_projects', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->comment('Nombre del Proyecto');
                $table->string('code')->unique()->comment('Código del Proyecto');
                $table->string('onapre_code')->nullable()->comment('Código otorgado por la ONAPRE');
                $table->boolean('active')->default(true)->comment('Indica si el proyecto esta activo');
                $table->bigInteger('department_id')->unsigned()
                      ->comment('Identificador asociado al departamento o dependencia administrativa');
                $table->bigInteger('payroll_position_id')->unsigned()
                      ->comment('Identificador asociado al cargo de la persona responsable del proyecto');
                $table->bigInteger('payroll_staff_id')->unsigned()
                      ->comment('Identificador asociado al cargo de la persona responsable del proyecto');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
                $table->foreign('department_id')->references('id')->on('departments')->onUpdate('cascade');
                $table->foreign('payroll_position_id')->references('id')->on('payroll_positions')->onUpdate('cascade');
                $table->foreign('payroll_staff_id')->references('id')->on('payroll_staffs')->onUpdate('cascade');
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
        Schema::dropIfExists('budget_projects');
    }
}
