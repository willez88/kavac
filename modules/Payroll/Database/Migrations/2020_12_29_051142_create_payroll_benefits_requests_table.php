<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      CreatePayrollBenefitsRequestsTable
 * @brief      Crear tabla de solicitud de adelanto de prestaciones
 *
 * Gestiona la creación o eliminación de la tabla de solicitud de adelanto de prestaciones
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePayrollBenefitsRequestsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_benefits_requests')) {
            Schema::create('payroll_benefits_requests', function (Blueprint $table) {
                $table->id()->comment('Identificador único del registro');
                $table->string('code')->nullable()->unique()
                      ->comment('Código asociado a la solicitud de adelanto de prestaciones');
                $table->string('status')
                      ->comment('Estatus de la solicitud de adelanto de prestaciones');
                $table->float('amount_requested')
                      ->comment('Monto solicitado para el adelanto de prestaciones');
                $table->string('motive')
                      ->comment('Motivo de la solicitud de adelanto de prestaciones');

                $table->text('status_parameters')->nullable()->comment(
                    'Parámetros del estatus: Si estatus aprobado, status_parameters = {approval_date} ' .
                        'Si estatus rechazado, status_parameters = {motive}'
                );

                $table->foreignId('payroll_staff_id')
                      ->comment('Identificador único asociado al trabajador')
                      ->constrained()->onDelete('restrict')->onUpdate('cascade');
                $table->foreignId('institution_id')->nullable()
                      ->comment('Identificador único asociado a la institución')
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
        Schema::dropIfExists('payroll_benefits_requests');
    }
}
