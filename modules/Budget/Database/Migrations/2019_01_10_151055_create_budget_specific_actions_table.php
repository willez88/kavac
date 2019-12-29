<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetSpecificActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('budget_specific_actions')) {
            Schema::create('budget_specific_actions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->date('from_date')->comment('Fecha de inicio del proyecto o acción central');
                $table->date('to_date')->comment('Fecha de fin del proyecto o acción central');
                $table->string('code')->comment('Código de la acción específica');
                $table->string('name')->comment('Nombre de la acción específica');
                $table->text('description')->comment('Descripción del Proyecto o Acción Central');
                $table->boolean('active')->default(true)->comment('Indica si la acción específica esta o no activa');
                $table->morphs('specificable');
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
        Schema::dropIfExists('budget_specific_actions');
    }
}
