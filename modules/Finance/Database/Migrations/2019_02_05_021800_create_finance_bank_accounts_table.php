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
            $table->foreignId('finance_banking_agency_id')->nullable()->constrained()
                  ->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('finance_account_type_id')->nullable()->constrained()
                  ->onDelete('restrict')->onUpdate('cascade');
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
