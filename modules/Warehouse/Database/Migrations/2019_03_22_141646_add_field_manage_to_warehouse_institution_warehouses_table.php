<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldManageToWarehouseInstitutionWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_institution_warehouses', function (Blueprint $table) {
            $table->boolean('manage')->default(true)
                      ->comment('Estatus de gestión. (true) activo, (false) inactivo');

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
            $table->dropColumn('manage');
        });
    }
}
