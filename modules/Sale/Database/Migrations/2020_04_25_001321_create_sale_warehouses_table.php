<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sale_warehouses')) {
            Schema::create('sale_warehouses', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->bigInteger('institution_id')->nullable()->comment('Institución');

                $table->foreign('institution_id')
                      ->references('id')->on('institutions')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->string('name', 100)->comment('Nombre o descripción del almacen');

                $table->boolean('main')->default(false)
                      ->comment('Define si es el almacen principal');

                $table->boolean('active')->default(true)
                      ->comment('Estatus de actividad. (true) activo, (false) inactivo');


                $table->bigInteger('parish_id')->nullable()->comment('Parroquia donde está ubicado el almacen');

                $table->foreign('parish_id')->references('id')->on('parishes')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->text('address')->comment('Dirección física del almacen');
                
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
        Schema::dropIfExists('sale_warehouses');
    }
}
