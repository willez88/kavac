<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('purchase_pivot_models_to_requirement_items');
        Schema::dropIfExists('purchase_quotations');
        Schema::dropIfExists('purchase_requirement_items');
        Schema::dropIfExists('purchase_requirements');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('purchase_base_budgets');
        Schema::dropIfExists('purchase_plans');
        Schema::dropIfExists('purchase_types');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
