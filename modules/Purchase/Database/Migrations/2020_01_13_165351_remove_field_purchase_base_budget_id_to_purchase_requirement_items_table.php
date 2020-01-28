<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldPurchaseBaseBudgetIdToPurchaseRequirementItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_requirement_items', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_requirement_items', 'purchase_base_budget_id')) {
                $table->dropColumn('purchase_base_budget_id');
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
        Schema::table('purchase_requirement_items', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_requirement_items', 'purchase_base_budget_id')) {
                $table->integer('purchase_base_budget_id')->unsigned()->nullable()
                      ->comment('identificador del registro del la base presupuestal');
                $table->foreign('purchase_base_budget_id')->references('id')
                      ->on('purchase_base_budgets')->onDelete('restrict')
                      ->onUpdate('cascade');
            }
        });
    }
}
