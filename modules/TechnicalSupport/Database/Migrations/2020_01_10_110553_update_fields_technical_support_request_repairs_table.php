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
        Schema::disableForeignKeyConstraints();

        if (Schema::hasTable('technical_support_request_repairs')) {
            Schema::table('technical_support_request_repairs', function (Blueprint $table) {
                if (Schema::hasColumn('technical_support_request_repairs', 'user_id')) {
                    $table->dropForeign(['user_id']);
                    $table->dropColumn('user_id');
                };
                if (Schema::hasColumn('technical_support_request_repairs', 'state')) {
                    $table->dropColumn(['state']);
                };
                if (!Schema::hasColumn('technical_support_request_repairs', 'technical_support_request_id')) {
                    $table->unsignedBigInteger('technical_support_request_id')->nullable()
                          ->comment('Identificador único de la solcitud de reparación asociada al registro');
                    $table->foreign(
                        'technical_support_request_id',
                        'technical_support_request_repairs_request_fk'
                    )->references('id')->on('technical_support_requests')->onDelete('restrict')->onUpdate('cascade');
                };
                if (!Schema::hasColumn('technical_support_request_repairs', 'technical_support_repair_id')) {
                    $table->unsignedBigInteger('technical_support_repair_id')->nullable()->comment(
                        'Identificador único de la reparación asociada al registro'
                    );
                    $table->foreign(
                        'technical_support_repair_id',
                        'technical_support_request_repairs_repair_fk'
                    )->references('id')->on('technical_support_repairs')->onDelete('restrict')->onUpdate('cascade');
                };
                if (!Schema::hasColumn('technical_support_request_repairs', 'technical_support_diagnostic_id')) {
                    $table->unsignedBigInteger('technical_support_diagnostic_id')->nullable()->comment(
                        'Identificador único del diagnóstico de la reparación asociada al registro'
                    );
                    $table->foreign(
                        'technical_support_diagnostic_id',
                        'technical_support_request_repairs_diagnostic_fk'
                    )->references('id')->on('technical_support_diagnostics')->onDelete('restrict')->onUpdate('cascade');
                };
            });
        }

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        if (Schema::hasTable('technical_support_request_repairs')) {
            Schema::table('technical_support_request_repairs', function (Blueprint $table) {
                if (!Schema::hasColumn('technical_support_request_repairs', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->constrained()->onDelete('restrict')->onUpdate('cascade');
                };
                if (!Schema::hasColumn('technical_support_request_repairs', 'state')) {
                    $table->string('state')->nullable()->comment('Estado de la solicitud');
                };

                if (Schema::hasColumn('technical_support_request_repairs', 'technical_support_request_id')) {
                    $table->dropForeign('technical_support_request_repairs_request_fk');
                    $table->dropColumn(['technical_support_request_id']);
                };
                if (Schema::hasColumn('technical_support_request_repairs', 'technical_support_repair_id')) {
                    $table->dropForeign('technical_support_request_repairs_repair_fk');
                    $table->dropColumn(['technical_support_repair_id']);
                };
            });
        }
        Schema::enableForeignKeyConstraints();
    }
}
