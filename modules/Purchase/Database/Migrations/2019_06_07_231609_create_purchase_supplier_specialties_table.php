<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseSupplierSpecialtiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('purchase_supplier_specialties')) {
            Schema::create('purchase_supplier_specialties', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->unique()->comment('Nombre de la especialidad de proveedores');
                $table->text('description')->nullable()->comment('Descripción de la especialidad de proveedores');
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
        Schema::dropIfExists('purchase_supplier_specialties');
    }
}
