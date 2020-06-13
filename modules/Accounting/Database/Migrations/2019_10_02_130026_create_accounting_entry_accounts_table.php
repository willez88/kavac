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
            $table->foreignId('accounting_entry_id')->constrained()->onDelete('cascade')
                  ->comment('id del asiento contable');
            $table->foreignId('accounting_account_id')->nullable()->constrained()->onDelete('cascade')->comment(
                'registro de cuentas patrimoniales en el asiento contable'
            );
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
