<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePurchaseCompromisesTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePurchaseCompromisesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('purchase_compromises')) {
            Schema::create('purchase_compromises', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->date('compromised_at')->nullable()->comment("Fecha en la que se establece el compromiso");
                $table->text('description')->comment("Descripción del compromiso");
                $table->string('code', 20)->unique()->comment("Código único que identifica el compromiso");
                $table->foreignId('document_status_id')->nullable()->constrained('document_status')
                      ->onDelete('restrict')->onUpdate('cascade');
                /** Relación para los beneficiarios del compromiso */
                $table->morphs('compromiseable');
                /** Relación para los documentos de origen que generan el compromiso */
                $table->nullableMorphs('sourceable');

                $table->string('document_number')->unique()->comment(
                    'Número del documento que identifica el compromiso. Si es manual se agrega el número indicado' .
                    'en el campo Documento Origen, de lo contrarió si proviene de otro proceso se coloca el código' .
                    'del documento'
                );

                $table->foreignId('institution_id')->nullable()->constrained()->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_compromises');
    }
}
