<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_bank_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ccc_number', 20)->comment('Número de Código de Cuenta Cliente');
            $table->string('description')->comment('Descripción u objetivo de la cuenta');
            $table->date('opened_at')->comment('Fecha en la que fue aperturada la cuenta bancaria');
            $table->bigInteger('finance_banking_agency_id')->unsigned()->nullable()
                  ->comment('Identificador de la agencia bancaria');
            $table->foreign('finance_banking_agency_id')->references('id')
                  ->on('finance_banking_agencies')->onDelete('restrict')->onUpdate('cascade');
            $table->bigInteger('finance_account_type_id')->unsigned()->nullable()
                  ->comment('Identificador del tipo de cuenta bancaria');
            $table->foreign('finance_account_type_id')->references('id')
                  ->on('finance_account_types')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('finance_bank_accounts');
    }
}
