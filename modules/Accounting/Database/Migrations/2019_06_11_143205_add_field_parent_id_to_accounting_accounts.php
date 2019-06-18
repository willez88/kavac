<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldParentIdToAccountingAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounting_accounts', function (Blueprint $table) {
            if (!Schema::hasColumn('accounting_accounts', 'parent_id')) {
                $table->integer('parent_id')->nullable()->unsigned()
                          ->comment('Identificador asociado a la cuenta padre');
                $table->foreign('parent_id')->references('id')
                      ->on('accounting_accounts')->onUpdate('cascade');
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
        Schema::table('accounting_accounts', function (Blueprint $table) {
            $table->dropForeign('accounting_accounts_parent_id_foreign');
            $table->dropColumn('parent_id');
        });
    }
}