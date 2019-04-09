<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountingSeatAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('accounting_seat_accounts')) {
            Schema::create('accounting_seat_accounts', function (Blueprint $table) {
                $table->increments('id');

                $table->integer('accounting_seat_id')->unsigned();
                $table->foreign('accounting_seat_id')->references('id')->on('accounting_seats')->onDelete('cascade')->comment('id del asiento contable');

                $table->integer('accounting_account_id')->unsigned()->nullable();
                $table->foreign('accounting_account_id')->references('id')->on('accounting_accounts')->onDelete('cascade')->comment('registro de cuentas patrimoniales en el asiento contable');

                $table->integer('budget_account_id')->unsigned()->nullable();
                $table->foreign('budget_account_id')->references('id')->on('budget_accounts')->onDelete('cascade')->comment(' registros de compromisos del asiento contable');



                $table->float('debit', 30, 2)->comment('Monto asignado al Debe total del asiento');
                $table->float('assets', 30, 2)->comment('Monto asignado al Haber total del Asiento');

                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
                $table->timestamps();
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
        Schema::dropIfExists('accounting_seat_accounts');
    }
}
