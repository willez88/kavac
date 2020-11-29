<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeletePurchaseTypeOperationIdToPurchasePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_plans', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_plans', 'purchase_type_operation_id')) {
                $table->dropForeign(['purchase_type_operation_id']);
                $table->dropColumn('purchase_type_operation_id');
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
        // No necesita accion reversa
    }
}
