<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequiredDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('required_documents')) {
            Schema::create('required_documents', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->comment('Nombre del documento requerido');
                $table->text('description')->nullable()->comment('Descripción del documento requerido');
                $table->string('module')->nullable()
                      ->comment('Nombre del módulo que define los documentos a solicitar');
                $table->string('model')->comment('Nombre del modelo que define los documentos a requerir');
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
        Schema::dropIfExists('required_documents');
    }
}
