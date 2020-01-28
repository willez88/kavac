<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceCheckBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_check_books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->comment('Código que identifica a la chequera');
            $table->string('number', 12)->comment('Numeración del cheque');
            $table->boolean('used')->default(false)->comment('Determina si el cheque ya fue emitido');
            $table->boolean('annulled')->default(false)->comment('Determina si el cheque se encuentra anulado');
            $table->bigInteger('finance_bank_account_id')->unsigned()
                  ->comment('Identificador de la cuenta bancaria a la cual pertenece el cheque');
            $table->foreign('finance_bank_account_id')->references('id')
                  ->on('finance_bank_accounts')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            $table->unique(['code', 'number', 'finance_bank_account_id'])->comment('Clave única para el registro');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_check_books');
    }
}
