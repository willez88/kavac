<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToPurchaseSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_suppliers', function (Blueprint $table) {
            $table->enum('rnc_status', ['INH', 'ISH', 'IHC', 'NOI'])->default('NOI')
                  ->comment(
                      <<<'EOF'
                      Determina el estatus en el Registro Nacional de Contratistas. Los Valores posibles son: 
                      (INH) - Inscrito y no habilitado. 
                      (ISH) - Inscrito y habilitado. 
                      (IHC) - Inscrito, habilitado y calificado. 
                      (NOI) - No inscrito
                      EOF
                  );
            $table->string('rnc_certificate_number')->nullable()
                  ->comment('Número de certificado en el Registro Nacional de Contratistas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_suppliers', function (Blueprint $table) {
            $table->dropColumn('rnc_status');
            $table->dropColumn('rnc_certificate_number');
        });
    }
}
