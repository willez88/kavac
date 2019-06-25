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
            $table->string('archive_number')->nullable()
                  ->comment('Número que permite identificar el documento físico en archivo');
            $table->boolean('physical_support')->default(false)
                  ->comment('Establece si el documento tiene un respaldo en físico');
            $table->longText('digital_support_original')->nullable()
                  ->comment('Soporte digital del documento original');
            $table->longText('digital_support_signed')->nullable()
                  ->comment('Soporte digital del documento firmado');
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
            $table->dropColumn('archive_number');
            $table->dropColumn('physical_support');
            $table->dropColumn('digital_support_original');
            $table->dropColumn('digital_support_signed');
        });
    }
}
