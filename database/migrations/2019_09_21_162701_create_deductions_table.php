<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('deductions')) {
            Schema::create('deductions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->comment("Nombre de la deducción");
                $table->text('description')->nullable()->comment("Descripción de la deducción");
                $table->text('formula')->comment("Fórmula de la deducción a aplicar");
                $table->boolean('active')->default(true)->comment('Establece si la deducción esta activa o no');
                $table->foreignId('accounting_account_id')->nullable()->constrained()
                      ->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('deductions');
    }
}
