<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateWarehouseRequestsTable
 * @brief Crear tabla de solicitudes de almacén
 *
 * Gestiona la creación o eliminación de la tabla de solicitudes de productos al almacén
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateWarehouseRequestsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_requests')) {
            Schema::create('warehouse_requests', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->string('code', 20)->unique()->comment('Código identificador de la solicitud');
                $table->string('state', 100)->nullable()->comment('Estado de la solicitud');
                $table->text('observations')->nullable()->comment('Observaciones de la solicitud');

                $table->text('motive')->comment('Motivo de la solicitud');
                $table->boolean('delivered')->default(false)
                      ->comment('Define si el almacén hizo entrega de la solicitud. (true)Si, (false)No');
                $table->date('delivery_date')->nullable()
                      ->comment('Fecha en la que se hizo la entrega de la solicitud');

                $table->bigInteger('budget_specific_action_id')->nullable()->unsigned()
                      ->comment('Identificador único de la acción específica asociada a la solicitud');
                $table->foreign('budget_specific_action_id')->references('id')->on('budget_specific_actions')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->bigInteger('payroll_staff_id')->nullable()->unsigned()
                      ->comment('Identificador único del trabajador que realiza la solicitud');
                $table->foreign('payroll_staff_id')->references('id')->on('payroll_staffs');

                $table->bigInteger('department_id')->nullable()->unsigned()
                      ->comment('Identificador único del departamento o dependencia que solicita los productos');
                $table->foreign('department_id')->references('id')->on('departments')
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
        Schema::dropIfExists('warehouse_requests');
    }
}
