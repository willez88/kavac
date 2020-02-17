<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteFieldsToPurchaseRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_requirements', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_requirements', 'purchase_base_budget_id')) {
                $table->dropColumn('purchase_base_budget_id');
            }

            if (Schema::hasColumn('purchase_requirements', 'purchase_order_id')) {
                $table->dropColumn('purchase_order_id');
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
        Schema::table('purchase_requirements', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_requirements', 'purchase_base_budget_id')) {
                $table->integer('purchase_base_budget_id')->unsigned()->nullable()
                      ->comment('identificador del registro del la base presupuestal');
                $table->foreign('purchase_base_budget_id')->references('id')
                      ->on('purchase_base_budgets')->onDelete('restrict')
                      ->onUpdate('cascade');
            }

            if (!Schema::hasColumn('purchase_requirements', 'purchase_order_id')) {
                $table->integer('purchase_order_id')->unsigned()->nullable()
                      ->comment('identificador del registro del la base presupuestal');
                $table->foreign('purchase_order_id')->references('id')
                      ->on('purchase_base_budgets')->onDelete('restrict')
                      ->onUpdate('cascade');
            }
        });
    }
}
