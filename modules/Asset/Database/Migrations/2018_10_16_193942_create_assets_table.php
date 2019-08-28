<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetsTable
 * @brief Crear tabla de bienes
 *
 * Gestiona la creación o eliminación de la tabla de bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateAssetsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('assets')) {
            Schema::create('assets', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->integer('asset_type_id')->unsigned()
                      ->comment('Identificador único del tipo de bien (1 Mueble, 2 Inmueble)');
                $table->foreign('asset_type_id')->references('id')->on('asset_types')
                      ->onDelete('restrict')->onUpdate('cascade');
                
                $table->integer('asset_category_id')->unsigned()
                      ->comment('Identificador único de la categoria general a la que pertence el bien');
                $table->foreign('asset_category_id')->references('id')->on('asset_categories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('asset_subcategory_id')->unsigned()
                      ->comment('Identificador único de la subcategoria a la que pertence el bien');
                $table->foreign('asset_subcategory_id')->references('id')->on('asset_subcategories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('asset_specific_category_id')->unsigned()
                      ->comment('Identificador único de la categoria especifica a la que pertence el bien');
                $table->foreign('asset_specific_category_id')->references('id')->on('asset_specific_categories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('asset_condition_id')->nullable()->unsigned()
                      ->comment('Identificador único de la condicion física del bien');
                $table->foreign('asset_condition_id')->references('id')->on('asset_conditions')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('asset_acquisition_type_id')->nullable()->unsigned()
                      ->comment('Identificador único del tipo de adquisicion del bien');
                $table->foreign('asset_acquisition_type_id')->references('id')->on('asset_acquisition_types')
                     ->onDelete('restrict')->onUpdate('cascade');
                
                $table->year('acquisition_year')->nullable()->unsigned()->comment('Año de adquisicion del bien');
                
                $table->integer('asset_status_id')->nullable()->unsigned()
                      ->comment('Identificador único del estatus de uso del bien');
                $table->foreign('asset_status_id')->references('id')->on('asset_status')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('asset_use_function_id')->nullable()->unsigned()
                      ->comment('Identificador único de la función de uso del bien (solo para bienes inmuebles)');
                $table->foreign('asset_use_function_id')->references('id')->on('asset_use_functions')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->string('serial', 50)->nullable()->comment('Serial del fabricante');

                $table->string('marca', 50)->nullable()->comment('Marca del bien');

                $table->string('model', 50)->nullable()->comment('Modelo del bien');

                $table->string('inventory_serial', 50)->nullable()
                      ->comment('Código que coloca el organismo en el bien para identificarlo');

                $table->float('value')->nullable()->unsigned()
                      ->comment('Valor en libros del bien');
                $table->integer('currency_id')->unsigned()->nullable()
                      ->comment('Identificador único asociado a la moneda');
                $table->foreign('currency_id')->references('id')->on('currencies')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->text('specifications')->nullable()->comment('Especificaciones técnicas del bien');
                
                /** Ubicación */
                $table->text('address')->nullable()->comment('Dirección fisíca de bien');
                $table->integer('parish_id')->nullable()->unsigned()
                      ->comment('Identificador único de la parroquia donde esta ubicado el bien');
                $table->foreign('parish_id')->references('id')->on('parishes')
                      ->onDelete('restrict')->onUpdate('cascade');
                
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
