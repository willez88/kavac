<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResetAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('purchase_pivots');
        Schema::dropIfExists('purchase_pivot_models_to_requirement_items');
        Schema::dropIfExists('purchase_quotations');
        Schema::dropIfExists('purchase_requirement_items');
        Schema::dropIfExists('purchase_requirements');
        Schema::dropIfExists('purchase_base_budgets');
        Schema::dropIfExists('purchase_plans');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('purchase_type_hirings');
        Schema::dropIfExists('purchase_types');
        Schema::dropIfExists('purchase_type_operations');
        Schema::dropIfExists('purchase_processes');
        Schema::dropIfExists('purchase_suppliers');
        Schema::dropIfExists('purchase_supplier_types');
        Schema::dropIfExists('purchase_supplier_specialties');
        Schema::dropIfExists('purchase_supplier_branches');
        Schema::dropIfExists('purchase_supplier_objects');
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
