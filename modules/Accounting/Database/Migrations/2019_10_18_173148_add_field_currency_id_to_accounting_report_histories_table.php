<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldCurrencyIdToAccountingReportHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounting_report_histories', function (Blueprint $table) {
            if (!Schema::hasColumn('accounting_report_histories', 'currency_id')) {
                $table->integer('currency_id')->unsigned()->nullable()
                ->comment('id del tipo de moneda en que se expresa el asiento');
                
                $table->foreign('currency_id')->references('id')->on('currencies')
                ->onDelete('cascade')->comment('id del tipo de moneda en que se expresa el asiento');
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
        Schema::table('accounting_report_histories', function (Blueprint $table) {
            if (Schema::hasColumn('accounting_report_histories', 'currency_id')) {
                $table->dropColumn('currency_id');
            }
        });
    }
}
