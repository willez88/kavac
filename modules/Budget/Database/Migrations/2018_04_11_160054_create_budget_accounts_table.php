<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('budget_accounts')) {
            Schema::create('budget_accounts', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->char('group', 1)->comment('Grupo al que pertenece la cuenta');
                $table->char('item', 2)->comment('Item de la cuenta');
                $table->char('generic', 2)->comment('Código genérico de la cuenta');
                $table->char('specific', 2)->comment('Específica de la cuenta');
                $table->char('subspecific', 2)->comment('Subespecífica de la cuenta');
                $table->text('denomination')->comment('Descripción de la cuenta');
                $table->boolean('active')->default(true)->comment('Indica si la cuenta esta activa');
                $table->boolean('resource')->comment('Indica si es una cuenta de reursos');
                $table->boolean('egress')->comment('Indica si es una cuenta de egresos');
                $table->integer('tax_id')->nullable()->unsigned()
                      ->comment('Identificador asociado al impuesto');
                $table->integer('parent_id')->nullable()->unsigned()
                      ->comment('Identificador asociado a la cuenta padre');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
                $table->foreign('tax_id')->references('id')->on('taxes')->onUpdate('cascade');
            });

            Schema::table('budget_accounts', function (Blueprint $table) {
                $table->foreign('parent_id')->references('id')->on('budget_accounts')->onUpdate('cascade');
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
        Schema::dropIfExists('budget_accounts');
    }
}
