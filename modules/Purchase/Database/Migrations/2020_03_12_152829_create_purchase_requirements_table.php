<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_requirements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 20)->unique()->comment('Código único para el requerimiento de compra');
            $table->text('description')->comment("Descripción del requerimiento");

            /*
            * -----------------------------------------------------------------------
            * Clave foránea a la relación del año fiscal
            * -----------------------------------------------------------------------
            *
            * Define la estructura de relación al año fiscal
            */
            $table->foreignId('fiscal_year_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

            /*
            * -----------------------------------------------------------------------
            * Clave foránea a la relación de la unidad contratante
            * -----------------------------------------------------------------------
            *
            * Define la estructura de relación a la unidad o departamento contratante del
            * requerimiento a registrar
            */
            $table->foreignId('contracting_department_id')->nullable()->constrained('departments')
                  ->onDelete('restrict')->onUpdate('cascade');

            /*
            * -----------------------------------------------------------------------
            * Clave foránea a la relación de la unidad usuaria
            * -----------------------------------------------------------------------
            *
            * Define la estructura de relación a la unidad o departamento usuaria del
            * requerimiento a registrar
            */
            $table->foreignId('user_department_id')->constrained('departments')
                  ->onDelete('restrict')->onUpdate('cascade');

            /*
            * -----------------------------------------------------------------------
            * Clave foránea a la relación del tipo de proveedor
            * -----------------------------------------------------------------------
            *
            * Define la estructura de relación al tipo de proveedor según el requerimiento
            * a ser registrado
            */
            $table->foreignId('purchase_supplier_type_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

            $table->foreignId('purchase_base_budget_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

            $table->enum('requirement_status', ['WAIT', 'PROCESSED', 'BOUGHT'])->default('WAIT')->comment(
                'Determina el estatus del requerimiento
                (WAIT) - en espera.
                (PROCESSED) - Procesado,
                (BOUGHT) - comprado',
            );

            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_requirements');
    }
}
