<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldActiveToAccountingAccountConvertersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('accounting_account_converters', 'active')) {
            Schema::table('accounting_account_converters', function (Blueprint $table) {
                $table->boolean('active')->default(true)->comment('Indica si la conversión esta activa');
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
        if (Schema::hasColumn('accounting_account_converters', 'active')) {
            Schema::table('accounting_account_converters', function (Blueprint $table) {
                $table->dropColumn('active');
            });
        }
    }
}
