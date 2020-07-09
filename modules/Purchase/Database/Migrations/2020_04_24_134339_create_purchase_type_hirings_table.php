<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseTypeHiringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('purchase_type_hirings')) { 
            Schema::create('purchase_type_hirings', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->date('date')->nullable()->comment('Fecha del tipo de contratación');
                $table->boolean('active')->default(true)->comment('Indica si el tipo de contratación esta activo');
                
                $table->integer('purchase_type_operation_id')->unsigned()->nullable()
                      ->comment('Tipo de objeto de la empresa. (B)ienes, (O)bras y (S)ervicios');
                $table->foreign('purchase_type_operation_id')->references('id')
                      ->on('purchase_type_operations')->onDelete('restrict')
                      ->onUpdate('cascade');

                $table->float('ut', 15, 2)->comment('Monto de unidades tributarias');
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
        Schema::dropIfExists('purchase_type_hirings');
    }
}
