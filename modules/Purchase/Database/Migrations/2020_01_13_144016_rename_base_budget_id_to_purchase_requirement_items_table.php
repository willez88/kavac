<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameBaseBudgetIdToPurchaseRequirementItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_requirement_items', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_requirement_items', 'base_budget_id')) {
                $table->renameColumn('base_budget_id', 'purchase_base_budget_id');
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
        //
    }
}
