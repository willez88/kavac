<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldLogoIdToFinanceBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_banks', function (Blueprint $table) {
            $table->integer('logo_id')->unsigned()->nullable()
                  ->comment('Identificador del logotipo del banco');
            $table->foreign('logo_id')->references('id')
                  ->on('images')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finance_banks', function (Blueprint $table) {
            $table->dropForeign('finance_banks_logo_id_foreign');
            $table->dropColumn('institution_id');
        });
    }
}
