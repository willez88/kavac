<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBaseBudgetIdToPurchaseRequirementItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_requirement_items', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_requirement_items', 'base_budget_id')) {
                $table->integer('base_budget_id')->unsigned()->nullable()
                      ->comment('identificador del registro del la base presupuestal');
                $table->foreign('base_budget_id')->references('id')
                      ->on('purchase_base_budgets')->onDelete('restrict')
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
        Schema::table('purchase_requirement_items', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_requirement_items', 'base_budget_id')) {
                $table->dropColumn('base_budget_id');
            }
        });
    }
}
