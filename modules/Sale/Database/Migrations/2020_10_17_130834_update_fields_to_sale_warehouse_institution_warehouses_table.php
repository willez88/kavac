<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldsToSaleWarehouseInstitutionWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_warehouse_institution_warehouses', function (Blueprint $table) {
            if (Schema::hasColumn('sale_warehouse_institution_warehouses', 'sale_warehouses_id')) {
                $table->dropForeign(['sale_warehouses_id']);
                $table->dropColumn('sale_warehouses_id');
            };
            if (!Schema::hasColumn('sale_warehouse_institution_warehouses', 'sale_warehouse_id')) {
                $table->foreignId('sale_warehouse_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
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
        Schema::table('sale_warehouse_institution_warehouses', function (Blueprint $table) {
            if (!Schema::hasColumn('sale_warehouse_institution_warehouses', 'sale_warehouse_id')) {
                $table->foreignId('sale_warehouse_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            }
        });
    }
}
