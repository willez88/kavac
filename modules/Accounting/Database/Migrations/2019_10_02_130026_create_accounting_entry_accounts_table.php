<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountingEntryAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_entry_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->integer('accounting_entry_id')->unsigned()->comment('id del asiento contable');
            $table->foreign('accounting_entry_id')->references('id')->on('accounting_entries')->onDelete('cascade')->comment('id del asiento contable');

            $table->integer('accounting_account_id')->unsigned()->nullable()->comment('registro de cuentas patrimoniales en el asiento contable');
            $table->foreign('accounting_account_id')->references('id')->on('accounting_accounts')->onDelete('cascade')->comment('registro de cuentas patrimoniales en el asiento contable');

            $table->float('debit', 30, 10)->comment('Monto asignado al Debe total del asiento');
            $table->float('assets', 30, 10)->comment('Monto asignado al Haber total del Asiento');
            
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
        Schema::dropIfExists('accounting_entry_accounts');
    }
}
