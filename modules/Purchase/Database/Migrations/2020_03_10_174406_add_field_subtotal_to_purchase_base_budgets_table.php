<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldSubTotalToPurchaseBaseBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_base_budgets', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_base_budget', 'subtotal')) {
                $table->float('subtotal', 12, 10)->nullable()
                      ->comment('Subtotal del registro de presupuesto base');
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
            if (Schema::hasColumn('purchase_base_budget', 'subtotal')) {
                $table->dropColumn('subtotal');
            }
        });
    }
}
