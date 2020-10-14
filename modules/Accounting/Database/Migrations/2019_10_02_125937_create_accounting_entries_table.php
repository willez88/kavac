<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountingEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_entries', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('from_date')->nullable()->comment('Fecha del asiento contable');
            $table->text('concept')->nullable()->comment('Descripción del concepto del asiento contable');
            $table->text('observations')->nullable()->comment(
                'Descripción de alguna observación para el asiento contable'
            );
            $table->text('reference')->comment(
                'Referencia para identificar el asiento contable de forma directa (ej:SOP-11-2222)'
            );
            $table->float('tot_debit', 30, 10)->comment('Monto asignado al Debe total del asiento');
            $table->float('tot_assets', 30, 10)->comment('Monto asignado al Haber total del Asiento');
            $table->foreignId('accounting_entry_categories_id')->nullable()->constrained()->onDelete('cascade')
                  ->comment('id de la categoria u origen por el cual se genero el asiento contable');
            $table->foreignId('currency_id')->nullable()->constrained()->onDelete('cascade')
                  ->comment('id del tipo de moneda en que se guardar el asiento contable');
            $table->boolean('approved')->default(false)->comment('Indica si el asiento contable fue verificado');
            $table->foreignId('institution_id')->nullable()->constrained()->onDelete('cascade')
                  ->comment('id de la institución que genero el asiento contable');
            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounting_entries');
    }
}
