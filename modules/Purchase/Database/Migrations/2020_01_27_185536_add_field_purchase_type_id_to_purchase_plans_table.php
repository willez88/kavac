<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldPurchaseTypeIdToPurchasePlansTable extends Migration
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
                $table->integer('purchase_type_id')->unsigned()->nullable()
                      ->comment('identificador del registro del tipo de compra');
                $table->foreign('purchase_type_id')->references('id')
                      ->on('taxes')->onDelete('restrict')
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
        Schema::table('purchase_plans', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_plans', 'purchase_type_id')) {
                $table->dropColumn('purchase_type_id');
            }
        });
    }
}
