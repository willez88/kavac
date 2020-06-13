<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetCompromisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('budget_compromises')) {
            Schema::create('budget_compromises', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->date('compromised_at')->comment("Fecha en la que se establece el compromiso");
                $table->text('description')->comment("Descripción del compromiso");
                $table->string('code', 20)->unique()->comment("Código único que identifica el compromiso");
                $table->foreignId('document_status_id')->nullable()->constrained('document_status')
                      ->onDelete('restrict')->onUpdate('cascade');
                /** Relación para los beneficiarios del compromiso */
                $table->morphs('compromiseable');
                /** Relación para los documentos de origen que generan el compromiso */
                $table->morphs('sourceable');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
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
        Schema::dropIfExists('budget_compromises');
    }
}
