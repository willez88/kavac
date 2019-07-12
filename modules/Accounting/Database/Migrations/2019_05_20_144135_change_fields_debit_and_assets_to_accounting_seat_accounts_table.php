<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldsDebitAndAssetsToAccountingSeatAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounting_seat_accounts', function (Blueprint $table) {
            $table->float('debit', 30, 10)->comment('Monto asignado al Debe')->change();
            $table->float('assets', 30, 10)->comment('Monto asignado al Haber')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
