<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollPermissionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_permission_requests', function (Blueprint $table) {
            $table->id();
            $table->date('date')->comment('Fecha de Solicitud');
            $table->date('start_date')->nullable()->comment('Fecha de inicio del permiso');
            $table->date('end_date')->nullable()->comment('Fecha final del permiso');
            $table->string('motive_permission', 100)->comment('Motivo de la solicitud de permiso');
            $table->integer('day_permission', 100)->comment('Dias de permiso');
            $table->string('status')
                  ->comment('Estatus de la solicitud de permiso');
            $table->foreignId('payroll_staff_id')->constrained()
                  ->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('payroll_permission_policy_id')->constrained()
                  ->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_permission_requests');
    }
}
