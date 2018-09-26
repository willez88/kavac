<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetsTable
 * @brief Crear tabla de Bienes
 * 
 * Gestiona la creación o eliminación de la tabla de Bienes
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class CreateAssetsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('assets')) {
            Schema::create('assets', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->integer('orden_compra_id')->nullable()->unsigned()
                      ->comment('Identificador único de la orden de compra del bien');
                /**
                 * $table->foreing('orden_compra_id')->references('id')->on('orden_compra');
                 *       ->onDelete('restrict')->onUpdate('cascade');
                 */

                
                $table->string('disposicion')->nullable()->comment('Disposición a la que pertenece el bien (01-Activo)');

                $table->integer('type_id')->unsigned()->comment('Identificador único del tipo de bien (1 Mueble, 2 Inmueble)');
                $table->foreign('type_id')->references('id')->on('asset_types')
                      ->onDelete('restrict')->onUpdate('cascade');
                
                $table->integer('category_id')->unsigned()->comment('Identificador único de la categoria general a la que pertence el bien');
                $table->foreign('category_id')->references('id')->on('asset_categories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('subcategory_id')->unsigned()->comment('Identificador único de la subcategoria a la que pertence el bien');
                $table->foreign('subcategory_id')->references('id')->on('asset_subcategories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('specific_category_id')->unsigned()->comment('Identificador único de la categoria especifica a la que pertence el bien');
                $table->foreign('specific_category_id')->references('id')->on('asset_specific_categories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('institution_id')->nullable()->unsigned()
                      ->comment('Identificador único de la ubicación física del bien en una institución');
                
                $table->foreign('institution_id')->references('id')->on('institutions')
                     ->onDelete('restrict')->onUpdate('cascade');
                

                $table->integer('proveedor_id')->nullable()->unsigned()
                      ->comment('Identificador único del proveedor al que se compró el bien en la tabla proveedor');
                /**
                 *$table->foreign('proveedor_id')->references('id')->on('proveedor');
                 *     ->onDelete('restrict')->onUpdate('cascade');
                **/

                $table->integer('condition_id')->nullable()->comment('Identificador único de la condicion física del bien');
                $table->foreign('condition_id')->references('id')->on('asset_conditions')
                      ->onDelete('restrict')->onUpdate('cascade');


                $table->integer('purchase_id')->nullable()->unsigned()->comment('Identificador único de la forma de adquisicion del bien');
                
                $table->foreign('purchase_id')->references('id')->on('asset_purchases')
                     ->onDelete('restrict')->onUpdate('cascade');
                

                $table->string('purchase_year')->nullable()->comment('Año de adquisicion del bien');
                
                $table->integer('status_id')->nullable()->comment('Identificador único del estatus de uso del bien');
                $table->foreign('status_id')->references('id')->on('asset_statuses')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('use_id')->nullable()->comment('Identificador único de la función de uso del bien (solo para bienes inmuebles)');
                $table->foreign('use_id')->references('id')->on('asset_uses')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->string('serial',50)->nullable()->comment('Serial del fabricante');

                $table->string('marca',50)->nullable()->comment('Marca del bien');

                $table->string('model',50)->nullable()->comment('Modelo del bien');

                $table->string('serial_inventario',50)->nullable()
                      ->comment('Código que coloca el organismo en el bien para identificarlo');

                $table->integer('value')->nullable()->unsigned()
                      ->comment('Valor en libros del artículo (BsS.)');

                $table->integer('quantity')->nullable()->unsigned()
                      ->comment('Cantidad del bien (Solo para bienes inmuebles)');
                
                /**
                 *
                 * Fecha de Ingreso
                **/
                $table->timestamps();

                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
