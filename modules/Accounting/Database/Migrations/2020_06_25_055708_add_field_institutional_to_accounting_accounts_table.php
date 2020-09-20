<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldInstitutionalToAccountingAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('accounting_accounts')) {
            Schema::table('accounting_accounts', function (Blueprint $table) {
                $table->char('institutional', 3)->default('000')->nullable()->comment(
                    'Numero para la cuenta utilizado por instituciones'
                );
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
        if (Schema::hasTable('accounting_accounts')) {
            Schema::table('accounting_accounts', function (Blueprint $table) {
                $table->dropColumn('institutional');
            });
        }
    }
}
