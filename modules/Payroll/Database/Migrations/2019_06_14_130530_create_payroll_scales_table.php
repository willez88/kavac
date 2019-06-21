<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollScalesTable
 * @brief Crear tabla de escalas o niveles de un escalafón salarial
 *
 * Gestiona la creación o eliminación de la tabla de escalas o niveles de un escalafón salarial
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class CreatePayrollScalesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function up()
    {
        Schema::create('payroll_scales', function (Blueprint $table) {
            $table->increments('id')->comment('Identificador único del registro');
            
            $table->string('name')->comment('Nombre de la escala o nivel');
            $table->string('code',5)->nullable()->comment('Código de la escala o nivel');
            $table->text('description')->nullable()->comment('Descripción de la escala o nivel');
            
            
            $table->integer('payroll_salary_scale_id')->unsigned()->comment('Identificador único del escalafón salarial al que pertenece la escala o nivel');
            $table->foreign('payroll_salary_scale_id')->references('id')->on('payroll_salary_scales')
                  ->onDelete('restrict')->onUpdate('cascade');

            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
        });
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function down()
    {
        Schema::dropIfExists('payroll_scales');
    }
}
