<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldMainToWarehouseInstitutionWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_institution_warehouses', function (Blueprint $table) {
            if (!Schema::hasColumn('warehouse_institution_warehouses', 'main')) {
                $table->boolean('main')->default(false)
                      ->comment('Define si es el almacen principal');
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
        Schema::table('warehouse_institution_warehouses', function (Blueprint $table) {

        });
    }
}
