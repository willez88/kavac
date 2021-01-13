<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      CreatePayrollVacationRequestsTable
 * @brief      Crear tabla de solicitud de vacaciones
 *
 * Gestiona la creación o eliminación de la tabla de solicitud de vacaciones
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePayrollVacationRequestsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_vacation_requests')) {
            Schema::create('payroll_vacation_requests', function (Blueprint $table) {
                $table->id()->comment('Identificador único del registro');

                $table->string('code')->nullable()->unique()
                      ->comment('Código asociado a la solicitud de vacaciones');
                $table->string('status')
                      ->comment('Estatus de la solicitud de vacaciones');

                $table->unsignedInteger('days_requested')
                      ->comment('Días solicitados');
                $table->unsignedInteger('vacation_period_year')
                      ->comment('Año del período vacacional');

                $table->date('start_date')->comment('Fecha de inicio del período vacacional');
                $table->date('end_date')->comment('Fecha de culminación del período vacacional');

                $table->foreignId('payroll_staff_id')
                      ->comment('Identificador único asociado al trabajador')
                      ->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        };
    }

    /**
     * Método que elimina las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_vacation_requests');
    }
}
