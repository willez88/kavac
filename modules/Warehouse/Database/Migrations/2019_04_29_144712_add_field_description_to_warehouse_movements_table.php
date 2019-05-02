<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldDescriptionToWarehouseMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_movements', function (Blueprint $table) {
            if (Schema::hasColumn('warehouse_movements', 'motive')) {
                $table->dropColumn('motive');
            }

            if (!Schema::hasColumn('warehouse_movements', 'description')) {
                $table->string('description')->nullable()
                      ->comment('Motivo o descripcion del movimiento de almacen');
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
        Schema::table('warehouse_movements', function (Blueprint $table) {

        });
    }
}
