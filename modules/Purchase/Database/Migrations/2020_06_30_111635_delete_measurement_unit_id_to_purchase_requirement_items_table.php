<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteMeasurementUnitIdToPurchaseRequirementItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('purchase_requirement_items')) {
            Schema::table('purchase_requirement_items', function (Blueprint $table) {
                $table->dropForeign(['measurement_unit_id']);
                $table->dropColumn('measurement_unit_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('purchase_requirement_items')) {
            Schema::table('purchase_requirement_items', function (Blueprint $table) {
                /*
                * -----------------------------------------------------------------------
                * Clave foránea a la relación del producto
                * -----------------------------------------------------------------------
                *
                * Define la estructura de relación al producto
                */
                $table->foreignId('measurement_unit_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            });
        }
    }
}
