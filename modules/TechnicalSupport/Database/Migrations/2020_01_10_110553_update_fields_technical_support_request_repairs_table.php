<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldsTechnicalSupportRequestRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('technical_support_request_repairs')) {
            Schema::table('technical_support_request_repairs', function (Blueprint $table) {
                if (Schema::hasColumn('technical_support_request_repairs', 'user_id')) {
                    $table->dropForeign(['user_id']);
                    $table->dropColumn(['user_id']);
                };
                if (Schema::hasColumn('technical_support_request_repairs', 'state')) {
                    $table->dropColumn(['state']);
                };
                if (!Schema::hasColumn('technical_support_request_repairs', 'technical_support_request_id')) {
                    $table->bigInteger('technical_support_request_id')->unsigned()->nullable()
                          ->comment('Identificador único de la solcitud de reparación asociada al registro');
                    $table->foreign('technical_support_request_id')->references('id')
                          ->on('technical_support_requests')->onDelete('restrict')->onUpdate('cascade');
                };
                if (!Schema::hasColumn('technical_support_request_repairs', 'technical_support_repair_id')) {
                    $table->bigInteger('technical_support_repair_id')->unsigned()->nullable()
                          ->comment('Identificador único de la reparación asociada al registro');
                    $table->foreign('technical_support_repair_id')->references('id')
                          ->on('technical_support_repairs')->onDelete('restrict')->onUpdate('cascade');
                };
                if (!Schema::hasColumn('technical_support_request_repairs', 'technical_support_diagnostic_id')) {
                    $table->bigInteger('technical_support_diagnostic_id')->unsigned()->nullable()
                          ->comment('Identificador único del diagnóstico de la reparación asociada al registro');
                    $table->foreign('technical_support_diagnostic_id')->references('id')
                          ->on('technical_support_diagnostics')->onDelete('restrict')->onUpdate('cascade');
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
        if (Schema::hasTable('technical_support_request_repairs')) {
            Schema::table('technical_support_request_repairs', function (Blueprint $table) {
                if (!Schema::hasColumn('technical_support_request_repairs', 'user_id')) {
                    $table->bigInteger('user_id')->nullable()
                      ->comment('Identificador único del usuario que solicita la reparación');
                    $table->foreign('user_id')->references('id')->on('users')
                          ->onDelete('restrict')->onUpdate('cascade');
                };
                if (!Schema::hasColumn('technical_support_request_repairs', 'state')) {
                    $table->string('state')->nullable()->comment('Estado de la solicitud');
                };

                if (Schema::hasColumn('technical_support_request_repairs', 'technical_support_request_id')) {
                    $table->dropForeign(['technical_support_request_id']);
                    $table->dropColumn(['technical_support_request_id']);
                };
                if (Schema::hasColumn('technical_support_request_repairs', 'technical_support_repair_id')) {
                    $table->dropForeign(['technical_support_repair_id']);
                    $table->dropColumn(['technical_support_repair_id']);
                };
            });
        }
    }
}
