<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetsTable
 * @brief Crear tabla de bienes institucionales
 *
 * Gestiona la creación o eliminación de la tabla de bienes institucionales
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
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('assets')) {
            Schema::create('assets', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->foreignId('asset_type_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->foreignId('asset_category_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->foreignId('asset_subcategory_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->foreignId('asset_specific_category_id')->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->foreignId('asset_condition_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->foreignId('asset_acquisition_type_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->year('acquisition_year')->nullable()->unsigned()->comment('Año de adquisicion del bien');

                $table->foreignId('asset_status_id')->nullable()->constrained('asset_status')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->foreignId('asset_use_function_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->string('serial', 50)->nullable()->comment('Serial del fabricante');

                $table->string('marca', 50)->nullable()->comment('Marca del bien');

                $table->string('model', 50)->nullable()->comment('Modelo del bien');

                $table->string('inventory_serial', 50)->nullable()
                      ->comment('Código que coloca el organismo en el bien para identificarlo');

                $table->float('value')->nullable()->unsigned()
                      ->comment('Valor en libros del bien');
                $table->foreignId('currency_id')->nullable()->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->text('specifications')->nullable()->comment('Especificaciones técnicas del bien');

                $table->text('address')->nullable()->comment('Dirección fisíca de bien');
                $table->foreignId('parish_id')->nullable()->constrained()->onDelete('restrict')->onUpdate('cascade');

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
