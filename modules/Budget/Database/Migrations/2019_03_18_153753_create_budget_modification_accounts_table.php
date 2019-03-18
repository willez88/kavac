<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetModificationAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_modification_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->float('amount', 30, 10)->comment('Monto asignado a la cuenta presupuestaria');
            $table->enum('operation', ['I', 'D'])->comment('Operación a realizar: (I)ncrementa o (D)isminuye');
            $table->integer('budget_sub_specific_formulation_id')->unsigned()
                  ->comment('Identificador asociado a la Formulación');
            $table->integer('budget_account_id')->unsigned()
                  ->comment('Identificador asociado a la cuenta presupuestaria');
            $table->integer('budget_modification_id')->unsigned()
                  ->comment('Identificador asociado a la modificación presupuestaria');
            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            $table->foreign('budget_sub_specific_formulation_id')->references('id')
                  ->on('budget_sub_specific_formulations')->onUpdate('cascade');
            $table->foreign('budget_account_id')->references('id')
                  ->on('budget_accounts')->onUpdate('cascade');
            $table->foreign('budget_modification_id')->references('id')
                  ->on('budget_modifications')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budget_modification_accounts');
    }
}
