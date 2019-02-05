<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldCityIdToFinanceBankingAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_banking_agencies', function (Blueprint $table) {
            $table->integer('city_id')->unsigned()->nullable()
                  ->comment('Identificador de la ciudad donde esta ubicada la agencia');
            $table->foreign('city_id')->references('id')
                  ->on('cities')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finance_banking_agencies', function (Blueprint $table) {
            $table->dropColumn('city_id');
        });
    }
}
