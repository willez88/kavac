<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitizenServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('citizen_service_requests')) {
            Schema::create('citizen_service_requests', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('first_name', 100)->comment('Nombre del Solicitante');
                $table->string('last_name', 100)->comment('Apellido del Solicitante');
                $table->string('id_number', 12)->unique()->comment('Cédula de identidad del Solicitante');
                $table->string('email')->unique()->nullable()->comment('Correo electrónico del Solicitante');
                $table->string('phone', 20)->nullable()->comment('Teléfono del Solicitante');
                $table->date('date')->comment('Fecha de Solicitud');
                $table->string('institution_name', 200)->comment('Nombre de la institución');
                $table->string('institution_address', 200)->comment('Dirección de la institución');
                $table->string('web', 200)->comment('Dirección Web');
                $table->string('information', 200)->comment('Información Adicional');
                $table->foreignId('city_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
                $table->foreignId('municipality_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
                $table->foreignId('payroll_sector_type_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
                $table->foreignId('citizen_service_request_type_id')->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');
                $table->foreignId('document_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citizen_service_requests');
    }
}
