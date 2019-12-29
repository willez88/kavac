<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('purchase_suppliers')) {
            Schema::create('purchase_suppliers', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('rif', 10)->comment('Registro de Información Fiscal del proveedor');
                $table->string('code', 20)->unique()
                      ->comment('Código generado por el sistema para identificar al proveedor');
                $table->string('name')->comment('Nombre o razón social del proveedor');
                $table->enum('person_type', ['N', 'J'])->comment('Tipo de persona. (N)atural o (J)urídica');
                $table->enum('company_type', ['PU', 'PR'])->comment('Tipo de empresa. (PU)blica o (PR)ivada');
                $table->text('direction')->comment('Dirección del proveedor');
                $table->string('contact_name')->nullable()->comment('Nombre de la persona de contacto');
                $table->string('contact_email')->nullable()->comment('Correo electrónico de contacto');
                $table->text('website')->nullable()->comment('Sitio web del proveedor');
                $table->boolean('active')->default(false)->comment('Indica si el proveedor esta activo');

                /*
                * -----------------------------------------------------------------------
                * Clave foránea a la relación del objeto del proveedor
                * -----------------------------------------------------------------------
                *
                * Define la estructura de relación a la información del objeto del proveedor
                */
                $table->bigInteger('purchase_supplier_object_id')->unsigned()
                      ->comment('Identificador del objeto del proveedor');
                $table->foreign('purchase_supplier_object_id')->references('id')
                      ->on('purchase_supplier_objects')->onDelete('restrict')
                      ->onUpdate('cascade');

                /*
                * -----------------------------------------------------------------------
                * Clave foránea a la relación de la rama del proveedor
                * -----------------------------------------------------------------------
                *
                * Define la estructura de relación a la información de la rama del proveedor
                */
                $table->bigInteger('purchase_supplier_branch_id')->unsigned()
                      ->comment('Identificador de la rama del proveedor');
                $table->foreign('purchase_supplier_branch_id')->references('id')
                      ->on('purchase_supplier_branches')->onDelete('restrict')
                      ->onUpdate('cascade');

                /*
                * -----------------------------------------------------------------------
                * Clave foránea a la relación de la especialidad del proveedor
                * -----------------------------------------------------------------------
                *
                * Define la estructura de relación a la información de la especialidad del proveedor
                */
                $table->bigInteger('purchase_supplier_specialty_id')->unsigned()
                      ->comment('Identificador de la especialidad del proveedor');
                $table->foreign('purchase_supplier_specialty_id')->references('id')
                      ->on('purchase_supplier_specialties')->onDelete('restrict')
                      ->onUpdate('cascade');

                /*
                * -----------------------------------------------------------------------
                * Clave foránea a la relación del tipo de proveedor
                * -----------------------------------------------------------------------
                *
                * Define la estructura de relación a la información del tipo de proveedor
                */
                $table->bigInteger('purchase_supplier_type_id')->unsigned()
                      ->comment('Identificador del tipo de proveedor (Denominación comercial)');
                $table->foreign('purchase_supplier_type_id')->references('id')
                      ->on('purchase_supplier_types')->onDelete('restrict')->onUpdate('cascade');

                /*
                * -----------------------------------------------------------------------
                * Clave foránea a la relación de la ciudad del proveedor
                * -----------------------------------------------------------------------
                *
                * Define la estructura de relación a la información de la ciudad en donde
                * se encuentra ubicado proveedor
                */
                $table->bigInteger('city_id')->unsigned()
                      ->comment(
                          'Identificador de la Ciudad donde se encuentra ubicado el proveedor'
                      );
                $table->foreign('city_id')->references('id')
                      ->on('cities')->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
                $table->unique(['code', 'active'])->comment('Clave única para el registro');
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
        Schema::dropIfExists('purchase_suppliers');
    }
}
