<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleTypeGoodAttributesTable
 * @brief Crear tabla de los atributos de tipos de bienes
 *
 * Gestiona la creación o eliminación de la tabla de attributos de tipos de bienes
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateSaleTypeGoodAttributesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sale_type_good_attributes')) {
            Schema::create('sale_type_good_attributes', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->string('name', 100)->nullable()
                      ->comment('Nombre o descripción del atributo o característica específica del tipo de bien');

                $table->foreignId('sale_type_good_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('sale_type_good_attributes');
    }
}
