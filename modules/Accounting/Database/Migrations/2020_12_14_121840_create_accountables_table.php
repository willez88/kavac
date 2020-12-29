<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Elimina antigua tabla pivote para el convertidor de cuentas
        Schema::dropIfExists('accounting_account_converters');

        // nueva tabla usada para el convertidor de cuentas
        if (!Schema::hasTable('accountables')) {
            Schema::create('accountables', function (Blueprint $table) {
                $table->id();

                $table->foreignId('accounting_account_id')->constrained()->onDelete('cascade')->comment(
                    'llave foranea a registro en la tabla accounting_accounts'
                );

                $table->morphs('accountable');

                $table->boolean('active')->default(true)->comment('Indica si la conversión esta activa');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accountables');
    }
}
