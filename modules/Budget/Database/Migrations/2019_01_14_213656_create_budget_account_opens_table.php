<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetAccountOpensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('budget_account_opens')) {
            Schema::create('budget_account_opens', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->float('jan_amount', 30, 10)->default(0)->comment('Monto del mes de Enero');
                $table->float('feb_amount', 30, 10)->default(0)->comment('Monto del mes de Febrero');
                $table->float('mar_amount', 30, 10)->default(0)->comment('Monto del mes de Marzo');
                $table->float('apr_amount', 30, 10)->default(0)->comment('Monto del mes de Abril');
                $table->float('may_amount', 30, 10)->default(0)->comment('Monto del mes de Mayo');
                $table->float('jun_amount', 30, 10)->default(0)->comment('Monto del mes de Junio');
                $table->float('jul_amount', 30, 10)->default(0)->comment('Monto del mes de Julio');
                $table->float('aug_amount', 30, 10)->default(0)->comment('Monto del mes de Agosto');
                $table->float('sep_amount', 30, 10)->default(0)->comment('Monto del mes de Septiembre');
                $table->float('oct_amount', 30, 10)->default(0)->comment('Monto del mes de Octubre');
                $table->float('nov_amount', 30, 10)->default(0)->comment('Monto del mes de Noviembre');
                $table->float('dec_amount', 30, 10)->default(0)->comment('Monto del mes de Diciembre');
                $table->float('total_year_amount', 30, 10)->comment('Monto o cantidad total formulada');
                $table->float('total_real_amount', 30, 10)->comment('Monto o cantidad total real del año anterior');
                $table->float('total_estimated_amount', 30, 10)
                      ->comment('Monto o cantidad total estimada para el año de formulación');
                $table->bigInteger('budget_account_id')->unsigned()
                      ->comment('Identificador asociado a la cuenta patrimonial');
                $table->bigInteger('budget_sub_specific_formulation_id')->unsigned()
                      ->comment('Identificación asociado a la formulación');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
                $table->foreign('budget_account_id')->references('id')
                      ->on('budget_accounts')->onUpdate('cascade');
                $table->foreign('budget_sub_specific_formulation_id')->references('id')
                      ->on('budget_sub_specific_formulations')->onUpdate('cascade');
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
        Schema::dropIfExists('budget_account_opens');
    }
}
