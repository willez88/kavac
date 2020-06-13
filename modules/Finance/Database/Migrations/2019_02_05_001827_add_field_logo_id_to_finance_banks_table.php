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
            $table->unsignedBigInteger('logo_id')->nullable()
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
        Schema::disableForeignKeyConstraints();
        Schema::table('finance_banks', function (Blueprint $table) {
            if (Schema::hasColumn('finance_banks', 'logo_id')) {
                $table->dropForeign(['logo_id']);
                $table->dropColumn('logo_id');
            }
            if (Schema::hasColumn('finance_banks', 'institution_id')) {
                $table->dropForeign(['institution_id']);
                $table->dropColumn('institution_id');
            }
        });
        Schema::enableForeignKeyConstraints();
    }
}
