l<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('purchase_processes')) {
            Schema::create('purchase_processes', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->comment('Nombre del proceso de compra');
                $table->text('description')->comment('Descripción del proceso de compra');
                $table->boolean('require_documents')->default(false)
                      ->comment('Indica si el proceso de compra require cargar documentos');
                /*$table->json('list_documents')->nullable()
                      ->comment('Listado de documentos a consignar en el proceso de compra');*/
                $table->longText('list_documents')->nullable()
                      ->comment('Listado de documentos a consignar en el proceso de compra');
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
        Schema::dropIfExists('purchase_processes');
    }
}
