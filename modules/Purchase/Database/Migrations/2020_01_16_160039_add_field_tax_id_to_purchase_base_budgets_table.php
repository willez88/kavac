<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldTaxIdToPurchaseBaseBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_base_budgets', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_base_budgets', 'tax_id')) {
                $table->integer('tax_id')->unsigned()->nullable()
                      ->comment('identificador del registro del la base presupuestal');
                $table->foreign('tax_id')->references('id')
                      ->on('taxes')->onDelete('restrict')
                      ->onUpdate('cascade');
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
        Schema::table('purchase_base_budgets', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_base_budgets', 'tax_id')) {
                $table->dropColumn('tax_id');
            }
        });
    }
}
