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
                $table->bigInteger('city_id')->unsigned()
                      ->comment('Identificador unico de la ciudad a la que pertenece el solicitante');
                $table->foreign('city_id')->references('id')->on('cities')
                      ->onDelete('restrict')->onUpdate('cascade');
                $table->bigInteger('municipality_id')->unsigned()
                      ->comment('Identificador unico del municipio al que pertenece el solicitante');
                $table->foreign('municipality_id')->references('id')->on('municipalities')
                      ->onDelete('restrict')->onUpdate('cascade');
                $table->bigInteger('payroll_sector_type_id')->unsigned()
                      ->comment('Identificador unico del tipo de sector de un organismo');
                $table->foreign('payroll_sector_type_id')->references('id')->on('payroll_sector_types')
                      ->onDelete('restrict')->onUpdate('cascade');
                $table->bigInteger('citizen_service_request_type_id')->unsigned()
                      ->comment('Identificador unico del tipo de solicitud');
                $table->foreign('citizen_service_request_type_id')
                      ->references('id')->on('citizen_service_request_types')
                      ->onDelete('restrict')->onUpdate('cascade');
                $table->bigInteger('document_id')->unsigned()
                      ->comment('Identificador unico del archivo adjuntar');
                $table->foreign('document_id')->references('id')->on('documents')
                      ->onDelete('restrict')->onUpdate('cascade');
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
