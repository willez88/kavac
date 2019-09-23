<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseSupplierBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('purchase_supplier_branches')) {
            Schema::create('purchase_supplier_branches', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->comment('Nombre de la rama del proveedor');
                $table->text('description')->nullable()
                      ->comment('Descripción de la rama del proveedor. Opcional');
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
        Schema::dropIfExists('purchase_supplier_branches');
    }
}
