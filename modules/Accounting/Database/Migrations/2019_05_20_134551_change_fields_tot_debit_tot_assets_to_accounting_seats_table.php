<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldsTotDebitTotAssetsToAccountingSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounting_seats', function (Blueprint $table) {
            $table->float('tot_debit', 30, 10)->comment('Monto asignado al Debe total del asiento')->change();
            $table->float('tot_assets', 30, 10)->comment('Monto asignado al Haber total del Asiento')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('accounting_seats')) {
            Schema::table('accounting_seats', function (Blueprint $table) {
                $table->dropColumn(['tot_debit', 'tot_assets']);
            });
        }
    }
}
