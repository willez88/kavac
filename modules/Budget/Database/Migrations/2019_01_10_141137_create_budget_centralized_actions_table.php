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
                $table->foreignId('department_id')->constrained()->onUpdate('cascade');
                $table->foreignId('payroll_position_id')->constrained()->onUpdate('cascade');
                $table->foreignId('payroll_staff_id')->constrained()->onUpdate('cascade');
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
        Schema::dropIfExists('budget_centralized_actions');
    }
}
