<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'archive_number')) {
                $table->string('archive_number')->nullable()
                      ->comment('Número que permite identificar el documento físico en archivo');
            }
            if (!Schema::hasColumn('documents', 'physical_support')) {
                $table->boolean('physical_support')->default(false)
                      ->comment('Establece si el documento tiene un respaldo en físico');
            }
            if (!Schema::hasColumn('documents', 'digital_support_original')) {
                $table->longText('digital_support_original')->nullable()
                      ->comment('Soporte digital del documento original');
            }
            if (!Schema::hasColumn('documents', 'digital_support_signed')) {
                $table->longText('digital_support_signed')->nullable()
                      ->comment('Soporte digital del documento firmado');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            if (Schema::hasColumn('documents', 'archive_number')) {
                $table->dropColumn('archive_number');
            }
            if (Schema::hasColumn('documents', 'physical_support')) {
                $table->dropColumn('physical_support');
            }
            if (Schema::hasColumn('documents', 'digital_support_original')) {
                $table->dropColumn('digital_support_original');
            }
            if (Schema::hasColumn('documents', 'digital_support_signed')) {
                $table->dropColumn('digital_support_signed');
            }
        });
    }
}
