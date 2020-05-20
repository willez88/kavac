<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('institutions')) {
            Schema::create('institutions', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');
                $table->string('onapre_code', 20)->nullable()
                      ->comment('Código otorgado por la Oficina Nacional de Presupuesto (ONAPRE)');
                $table->string('rif', 10)->comment('Número de registro fiscal');
                $table->string('acronym', 100)
                      ->comment('Nombre corto (acronimo) de la institución');
                $table->string('name', 100)->comment('Nombre de la institución');
                $table->string('business_name', 100)->nullable()
                      ->comment('Razón social de la institución');
                $table->date('start_operations_date')->comment('Fecha de inicio de operaciones');
                $table->text('legal_base')->nullable()->comment('Base legal');
                $table->text('legal_form')->nullable()->comment('Forma Jurídica');
                $table->text('main_activity')->nullable()->comment('Actividad principal');
                $table->text('mission')->nullable()->comment('Misión');
                $table->text('vision')->nullable()->comment('Visión');
                $table->text('legal_address')->comment('Domicilio legal');
                $table->string('web', 200)->nullable()->comment('URL del sitio web institucional');
                $table->text('composition_assets')->nullable()->comment('Composición de patrimonio');
                $table->string('postal_code', 10)->comment('Código postal');
                $table->boolean('active')->default(true)
                      ->comment('Estatus de actividad. (true) activa, (false) inactiva');
                $table->boolean('default')->default(false)
                      ->comment('Institución por defecto. (true) SI, (false) NO');
                $table->boolean('retention_agent')->default(false)
                      ->comment('Agente de retención de impuestos. (true) SI, (false) NO');
                $table->bigInteger('institution_sector_id')->unsigned()
                      ->comment('Identificador asociado al sector al que pertenece');
                $table->bigInteger('municipality_id')->nullable()->unsigned()
                      ->comment('Identificador asociado al municipio en donde se encuentra ubicada');
                $table->bigInteger('city_id')->nullable()->unsigned()
                      ->comment('Identificador asociado a la ciudad en donde se encuentra ubicada');
                $table->bigInteger('institution_type_id')->unsigned()
                      ->comment('Identificador asociado al tipo de institución');
                $table->bigInteger('logo_id')->nullable()->unsigned()
                      ->comment('Identificador asociado al logotipo institucional');
                $table->bigInteger('banner_id')->nullable()->unsigned()
                      ->comment('Identificador asociado al cintillo institucional');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');

                $table->unique(['rif', 'active'])->comment('Clave única para el registro');
            });

            Schema::table('institutions', function (Blueprint $table) {
                $table->foreign('institution_sector_id')->references('id')->on('institution_sectors')
                      ->onUpdate('cascade');
                $table->foreign('municipality_id')->references('id')->on('municipalities')
                      ->onUpdate('cascade');
                $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade');
                $table->foreign('institution_type_id')->references('id')->on('institution_types')
                      ->onUpdate('cascade');
                $table->foreign('logo_id')->references('id')->on('images')->onUpdate('cascade');
                $table->foreign('banner_id')->references('id')->on('images')->onUpdate('cascade');
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
        Schema::dropIfExists('institutions');
    }
}
