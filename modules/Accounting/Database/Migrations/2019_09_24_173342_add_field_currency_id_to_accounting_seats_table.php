<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldCurrencyIdToAccountingSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounting_seats', function (Blueprint $table) {
            if (!Schema::hasColumn('accounting_seats', 'currency_id')) {
                $table->foreignId('currency_id')->nullable()->constrained()->onDelete('cascade')->comment(
                    'id del tipo de moneda en que se guardar el asiento contable'
                );
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounting_seats', function (Blueprint $table) {
            if (Schema::hasColumn('accounting_seats', 'currency_id')) {
                $table->dropColumn('currency_id');
            }
        });
    }
}
