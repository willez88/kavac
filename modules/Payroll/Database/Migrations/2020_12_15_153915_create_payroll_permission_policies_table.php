<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollPermissionPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_permission_policies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->comment('Nombre de la política de permiso');
            $table->integer('anticipation_day')->comment('Dias de anticipación del permiso');
            $table->integer('day_min')->comment('Número mínimo de días para el permiso');
            $table->integer('day_max')->comment('Número máxino de días para el permiso');
            $table->foreignId('institution_id')
                  ->comment('Identificador único asociado a la institución')
                  ->constrained()->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('payroll_permission_policies');
    }
}
