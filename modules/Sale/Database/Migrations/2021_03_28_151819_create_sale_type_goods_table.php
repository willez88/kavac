<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleTypeGoodsTable
 * @brief Crear tabla de los tipos de bienes
 *
 * Gestiona la creación o eliminación de la tabla de tipos de bienes
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateSaleTypeGoodsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::create('sale_type_goods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 60)->nullable()->comment('Nombre');
            $table->text('description')->nullable()->comment('Descripción');
            $table->boolean('define_attributes')->default(false)
                      ->comment('Establecer atributos personalizados. (true) si, (false) no');

            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
        });
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_type_goods');
    }
}
