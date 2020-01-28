<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetCentralizedActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('budget_centralized_actions')) {
            Schema::create('budget_centralized_actions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->date('custom_date')->comment('Fecha de creación personalizada indicada por el usuario');
                $table->string('name')->comment('Nombre de la Acción Centralizada');
                $table->string('code')->unique()->comment('Código de la Acción Centralizada');
                $table->boolean('active')->default(true)->comment('Indica si la acción centralizada esta activa');
                $table->bigInteger('department_id')->unsigned()
                      ->comment('Identificador asociado al departamento o dependencia administrativa');
                $table->bigInteger('payroll_position_id')->unsigned()
                      ->comment('Identificador asociado al cargo de la persona responsable de la acción centralizada');
                $table->bigInteger('payroll_staff_id')->unsigned()
                      ->comment('Identificador asociado al cargo de la persona responsable de la acción centralizada');
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
        Schema::dropIfExists('budget_centralized_actions');
    }
}
