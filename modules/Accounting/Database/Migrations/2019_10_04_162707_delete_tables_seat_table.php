<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteTablesSeatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('accounting_seat_accounts');
        Schema::dropIfExists('accounting_seats');
        Schema::dropIfExists('accounting_seat_categories');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('accounting_seat_categories')) {
            Schema::create('accounting_seat_categories', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->text('name')->comment('Nombre de la categoria u origen del cual se genero el asiento contable');
                $table->text('acronym')->comment('acrónimo utilizado al generar un asiento de manera automatica');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }

        if (!Schema::hasTable('accounting_seats')) {
            Schema::create('accounting_seats', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->date('from_date')->nullable()->comment('Fecha del asiento contable');
                $table->text('concept')->nullable()->comment('Descripción del concepto del asiento contable');
                $table->text('observations')->nullable()->comment('Descripción de alguna observación para el asiento contable');
                $table->text('reference')->comment('Referencia para identificar el asiento contable de forma directa (ej:SOP-11-2222)');

                $table->float('tot_debit', 30, 10)->comment('Monto asignado al Debe total del asiento');
                $table->float('tot_assets', 30, 10)->comment('Monto asignado al Haber total del Asiento');

                $table->integer('accounting_seat_categories_id')->unsigned()->nullable()->comment('id de la categoria u origen por el cual se genero el asiento contable');
                $table->foreign('accounting_seat_categories_id')->references('id')->on('accounting_entry_categories')->onDelete('cascade')->comment('id de la categoria u origen por el cual se genero el asiento contable');

                $table->integer('currency_id')->unsigned()->nullable()
                ->comment('id del tipo de moneda en que se guardar el asiento contable');
                
                $table->foreign('currency_id')->references('id')->on('currencies')
                ->onDelete('cascade')->comment('id del tipo de moneda en que se guardar el asiento contable');

                $table->boolean('approved')->default(false)->comment('Indica si el asiento contable fue verificado');

                $table->integer('institution_id')->unsigned()->nullable()->comment('id de la institución que genero el asiento contable');
                $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('cascade')->comment('id de la institución que genero el asiento contable');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }

        if (!Schema::hasTable('accounting_seat_accounts')) {
            $table->bigIncrements('id');
            
            $table->integer('accounting_seat_id')->unsigned()->comment('id del asiento contable');
            $table->foreign('accounting_seat_id')->references('id')->on('accounting_entries')->onDelete('cascade')->comment('id del asiento contable');

            $table->integer('accounting_account_id')->unsigned()->nullable()->comment('registro de cuentas patrimoniales en el asiento contable');
            $table->foreign('accounting_account_id')->references('id')->on('accounting_accounts')->onDelete('cascade')->comment('registro de cuentas patrimoniales en el asiento contable');

            $table->float('debit', 30, 10)->comment('Monto asignado al Debe total del asiento');
            $table->float('assets', 30, 10)->comment('Monto asignado al Haber total del Asiento');
            
            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
        }
    }
}
