<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldWarehouseInstitutionIdToWarehouseInventaryProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_inventary_products', function (Blueprint $table) {
            if (Schema::hasColumn('warehouse_inventary_products', 'warehouse_id')) {
                $table->dropColumn('warehouse_id');
            }
            if (!Schema::hasColumn('warehouse_inventary_products', 'warehouse_institution_id')) {
                $table->integer('warehouse_institution_id')->nullable()->comment('Identificador único del registro de la relación institución-almacén en el que está inventariado el producto');
                $table->foreign('warehouse_institution_id')->references('id')->on('warehouse_institution_warehouses')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::table('warehouse_inventary_products', function (Blueprint $table) {

        });
    }
}
