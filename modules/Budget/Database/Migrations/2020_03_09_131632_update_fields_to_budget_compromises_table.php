<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldsToBudgetCompromisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_compromises', function (Blueprint $table) {
            if (!Schema::hasColumn('budget_compromises', 'document_number')) {
                $table->string('document_number')->unique()
                      ->comment(<<<EOT
                          Número del documento que identifica el compromiso. Si es manual se agrega el número indicado 
                          en el campo Documento Origen, de lo contrarió si proviene de otro proceso se coloca el código 
                          del documento
                      EOT);
            }

            if (!Schema::hasColumn('budget_compromises', 'institution_id')) {
                $table->bigInteger('institution_id')->unsigned()->nullable()
                      ->comment('Identificador asociado a la institución');
                $table->foreign('institution_id')->references('id')
                      ->on('institutions')->onUpdate('cascade');
            }

            $table->date('compromised_at')->nullable()->comment("Fecha en la que se establece el compromiso")->change();

            $table->dropMorphs('sourceable');
        });

        Schema::table('budget_compromises', function (Blueprint $table) {
            $table->nullableMorphs('sourceable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_compromises', function (Blueprint $table) {
            if (Schema::hasColumn('budget_compromises', 'document_number')) {
                $table->dropColumn('document_number');
            }
            if (Schema::hasColumn('budget_compromises', 'institution_id')) {
                $table->dropForeign('budget_compromises_institution_id_foreign');
                $table->dropColumn('institution_id');
            }
            $table->date('compromised_at')->comment("Fecha en la que se establece el compromiso")->change();
            $table->dropMorphs('sourceable');
        });

        Schema::table('budget_compromises', function (Blueprint $table) {
            $table->morphs('sourceable');
        });
    }
}
