<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountingAccountConvertersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('accounting_account_converters')) {
            Schema::create('accounting_account_converters', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->foreignId('accounting_account_id')->constrained()->onDelete('cascade')->comment(
                    'llave foranea a registro en la tabla accounting_accounts'
                );

                $table->foreignId('budget_account_id')->constrained()->onDelete('cascade')->comment(
                    'llave foranea a registro en la tabla budget_accounts'
                );

                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
                $table->timestamps();
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
        Schema::dropIfExists('accounting_account_converters');
    }
}
