<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleTypeGoodValuesTable
 * @brief Crear tabla de los valores de los atributos de tipos de bienes
 *
 * Gestiona la creación o eliminación de la tabla de los valores de los attributos de tipos de bienes
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateSaleTypeGoodValuesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sale_type_good_values')) {
            Schema::create('sale_type_good_values', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->string('value', 100)->comment('Valor o descripción del atributo');
                $table->foreignId('sale_type_good_attribute_id')->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_type_good_values');
    }
}
