<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAbbreviationToWarehouseProductUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_product_units', function (Blueprint $table) {
            if (!Schema::hasColumn('warehouse_product_units', 'abbreviation')) {
                $table->string('abbreviation',4)->comment('Abreviatura de la unidad métrica');
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
        Schema::table('warehouse_product_units', function (Blueprint $table) {
            $table->dropColumn('abbreviation');

        });
    }
}
