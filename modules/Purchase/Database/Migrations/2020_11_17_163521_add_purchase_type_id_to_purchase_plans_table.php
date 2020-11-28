<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPurchaseTypeIdToPurchasePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_plans', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_plans', 'purchase_type_id')) {
                $table->foreignId('purchase_type_id')->nullable()->constrained()->onDelete('cascade')->comment(
                    'id del tipo de compra a relacionar con el registro'
                );
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
        Schema::table('purchase_plans', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_plans', 'purchase_type_id')) {
                $table->dropForeign(['purchase_type_id']);
                $table->dropColumn('purchase_type_id');
            }
        });
    }
}
