<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('document_status')) {
            Schema::create('document_status', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');
                $table->string('name', 20)->unique()->comment('Nombre del estatus del documento');
                $table->text('description')->nullable()
                      ->comment('Descripción detallada para el estatus del documento');
                $table->string('color', 30)->unique()->comment('Color del estatus del documento');
                $table->enum('action', ['AP', 'RE', 'EL', 'PR', 'AN', 'CE'])->default('AP')
                      ->comment(
                          'Acción que realiza el estado del documento. Valores aceptados: (AP)robado, ' .
                          '(RE)chazado, (EL)aborado, (PR)or revisar, (AN)ulado, (CE)rrado'
                      );
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
        Schema::dropIfExists('document_status');
    }
}
