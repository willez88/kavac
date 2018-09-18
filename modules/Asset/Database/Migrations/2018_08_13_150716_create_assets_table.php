<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('assets')) {
            Schema::create('assets', function (Blueprint $table) {
                $table->increments('id');


                $table->integer('type_id')->unsigned()
                      ->comment('Identificador único del tipo de bien 1 Mueble y 2 Inmueble');
                
                $table->integer('category_id')->unsigned()
                      ->comment('Identificador único de la categoria a la que pertence el bien');
                //$table->foreing('category_id')->references('id')->on('asset_category');

                $table->integer('subcategory_id')->unsigned()
                      ->comment('Identificador único de la subcategoria a la que pertence el bien');
                //$table->foreing('subcategory_id')->references('id')->on('asset_subcategory');

                $table->integer('specific_category_id')->unsigned()
                      ->comment('Identificador único de la categoria especifica a la que pertence el bien');
                //$table->foreing('specific_category_id')->references('id')->on('asset_specific_category');

                $table->integer('institucion_id')->nullable()->unsigned()
                      ->comment('Identificador único de la institucion a la que pertenece el bien');
                //$table->foreing('institucion_id')->references('id')->on('dependencia');

                $table->integer('proveedor_id')->nullable()->unsigned()
                      ->comment('Identificador del proveedor al que se compró el bien en la tabla proveedor');
                //$table->foreing('proveedor_id')->references('id')->on('proveedor');

                $table->string('condicion')->nullable()
                      ->comment('Condicion física del bien');

                $table->integer('purchase_id')->nullable()->unsigned()
                      ->comment('Forma de adquisicion del bien');

                $table->string('status')->nullable()
                      ->comment('Estatus de uso del bien');

                $table->string('purchase_year')->nullable()
                      ->comment('Año de adquisicion del bien');

                $table->string('serial',50)->nullable()
                      ->comment('Serial del fabricante');

                $table->string('marca',50)->nullable()
                      ->comment('Marca del bien');

                $table->string('modelo',50)->nullable()
                      ->comment('Modelo del bien');

                $table->string('serial_inventario',50)->nullable()
                      ->comment('Código que coloca el organismo en el bien para identificarlo');

                $table->integer('value')->nullable()->unsigned()
                      ->comment('Valor en libros del artículo (Bs.)');
                



                $table->integer('orden_compra_id')->nullable()->unsigned()
                      ->comment('Identificador de la orden de compra del bien');
                //$table->foreing('orden_compra_id')->references('id')->on('orden_compra');
                
                $table->integer('ubicacion_id')->nullable()->unsigned()
                      ->comment('identificador de la ubicación física del bien en la tabla dependencia');
                //$table->foreing('ubicacion_id')->references('id')->on('dependencia');
                
                
                $table->timestamps();   //fecha de ingreso
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
        Schema::dropIfExists('assets');
    }
}
