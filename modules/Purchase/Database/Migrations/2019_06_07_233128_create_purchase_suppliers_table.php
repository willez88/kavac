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
        Schema::create('purchase_suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rif', 10)->comment('Registro de Información Fiscal del proveedor');
            $table->string('name')->comment('Nombre del proveedor');
            $table->text('direction')->comment('Dirección del proveedor');
            $table->string('contact_name')->nullable()->comment('Nombre de la persona de contacto');
            $table->string('contact_email')->nullable()->comment('Correo electrónico de contacto');
            $table->text('website')->nullable()->comment('Sitio web del proveedor');
            $table->boolean('active')->default(false)->comment('Indica si el proveedor esta activo');
            $table->integer('parent_id')->unsigned()
                  ->comment(
                    'Identificador del proveedor asociado. Por defecto es nulo, si se modifica 
                    los datos de un proveedor se crea un nuevo registro y se asigna el id del 
                    registro modificado'
                  );
            $table->integer('purchase_supplier_specialty_id')->unsigned()
                  ->comment('Identificador de la especialidad del proveedor');
            $table->foreign('purchase_supplier_specialty_id')->references('id')
                  ->on('purchase_supplier_specialties')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('purchase_supplier_type_id')->unsigned()
                  ->comment('Identificador del tipo de proveedor');
            $table->foreign('purchase_supplier_type_id')->references('id')
                  ->on('purchase_supplier_types')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('municipality_id')->unsigned()
                  ->comment('Identificador del Municipio donde se encuentra ubicado el proveedor');
            $table->foreign('municipality_id')->references('id')
                  ->on('municipalities')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('city_id')->unsigned()
                  ->comment('Identificador de la Ciudad donde se encuentra ubicado el proveedor');
            $table->foreign('city_id')->references('id')
                  ->on('cities')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            $table->unique(array('rif', 'active', 'parent_id'))
                  ->comment('Clave única para el registro');
        });

        Schema::table('purchase_suppliers', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')
                  ->on('purchase_suppliers')->onDelete('cascade')->onUpdate('cascade');
        });
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
