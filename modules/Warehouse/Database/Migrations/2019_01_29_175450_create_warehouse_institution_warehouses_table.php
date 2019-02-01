<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehouseInstitutionWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_institution_warehouses')) {    
            Schema::create('warehouse_institution_warehouses', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->integer('institution_id')->comment('Identificador único de la institución que gestiona el almacén');
                $table->foreign('institution_id')->references('id')->on('institutions')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('warehouse_id')->comment('Identificador único del almacén');
                $table->foreign('warehouse_id')->references('id')->on('warehouses')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
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
        Schema::dropIfExists('warehouse_institution_warehouses');
    }
}
