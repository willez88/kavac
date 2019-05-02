<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldInventaryProductInitIdToWarehouseInventaryProductMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_inventary_product_movements', function (Blueprint $table) { 
            if (!Schema::hasColumn('warehouse_inventary_product_movements', 'inventary_product_init_id')) {
                $table->integer('inventary_product_init_id')->nullable()->comment('Identificador único del registro del inventario inicial donde se alojan los productos los productos movilizados');
                $table->foreign('inventary_product_init_id')->references('id')->on('warehouse_inventary_products')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::table('warehouse_inventary_product_movements', function (Blueprint $table) {

        });
    }
}
