<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('taxes')) {
            Schema::create('taxes', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');
                $table->string('name', 60)->unique()->comment('Nombre del impuesto');
                $table->text('description')->comment('Descripción del impuesto');
                $table->boolean('affect_tax')->default(false)
                      ->comment('Indica si afecta o no la cuenta presupuestaria de impuesto');
                $table->boolean('active')->default(true)->comment('Indica si el impuesto esta activo');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
                $table->unique(['name', 'active'])->comment('Clave única para el registro');
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
        Schema::dropIfExists('taxes');
    }
}
