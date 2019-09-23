<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseSupplierObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('purchase_supplier_objects')) {
            Schema::create('purchase_supplier_objects', function (Blueprint $table) {
                $table->increments('id');
                $table->enum('type', ['B', 'O', 'S'])
                      ->comment('Tipo de objeto de la empresa. (B)ienes, (O)bras y (S)ervicios');
                $table->string('name')->comment('Nombre del objeto del proveedor');
                $table->text('description')->nullable()
                      ->comment('Descripción del objeto del proveedor');
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
        Schema::dropIfExists('purchase_supplier_objects');
    }
}
