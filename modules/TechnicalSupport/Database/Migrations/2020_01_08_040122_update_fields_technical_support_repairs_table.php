<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldsTechnicalSupportRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('technical_support_repairs')) {
            Schema::table('technical_support_repairs', function (Blueprint $table) {
                if (Schema::hasColumn('technical_support_repairs', 'technical_support_request_repair_id')) {
                    $table->dropForeign('technical_support_repairs_request_fk');
                    $table->dropColumn('technical_support_request_repair_id');
                };
                if (Schema::hasColumn('technical_support_repairs', 'result')) {
                    $table->dropColumn('result');
                };
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
        if (Schema::hasTable('technical_support_repairs')) {
            Schema::table('technical_support_repairs', function (Blueprint $table) {
                if (!Schema::hasColumn('technical_support_repairs', 'technical_support_request_repair_id')) {
                    $table->bigInteger('technical_support_request_repair_id')->unsigned()
                        ->comment('Identificador único de la solcitud asociada a la reparación');
                    $table->foreign('technical_support_request_repair_id')->references('id')
                        ->on('technical_support_request_repairs')->onDelete('restrict')->onUpdate('cascade');
                };
                if (!Schema::hasColumn('technical_support_repairs', 'result')) {
                    $table->text('result')->nullable()->comment('Descripción de los resultados de la reparación');
                };
            });
        }
    }
}
