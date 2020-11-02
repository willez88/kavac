<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitizenServiceRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citizen_service_registers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_register')->comment('Fecha del registro');
            $table->string('first_name', 100)->comment('Nombre del director');
            $table->string('project_name', 100)->comment('Nombre del proyecto');
            $table->string('activities', 100)->comment('Actividades');
            $table->date('start_date')->comment('Fecha de inicio');
            $table->date('end_date')->comment('Fecha de culminación');
            $table->string('email')->unique()->nullable()->comment('Correo electrónico del responsable');
            $table->string('percent', 10)->comment('Porcentaje de cumplimiento');

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
        Schema::dropIfExists('citizen_service_registers');
    }
}
