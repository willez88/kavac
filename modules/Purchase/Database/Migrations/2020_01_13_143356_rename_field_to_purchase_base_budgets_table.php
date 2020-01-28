<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameFieldToPurchaseBaseBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_base_budgets', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_base_budgets', 'base_budget_id')) {
                $table->renameColumn('purchase_base_budget_id', 'base_budget_id');
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
            if (Schema::hasColumn('purchase_base_budgets', 'purchase_base_budget_id')) {
                $table->renameColumn('base_budget_id', 'purchase_base_budget_id');
            }
        });
    }
}
