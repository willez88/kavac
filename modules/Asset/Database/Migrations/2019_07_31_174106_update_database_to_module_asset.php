<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateDatabase
 * @brief Verifica y corrige la estandarización de las tablas del modulo de bienes
 *
 * Gestiona la creación o eliminación de la tabla de tipos de adquisición de un bien
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class UpdateDatabaseToModuleAsset extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        /** Elimino las migraciones antiguas */
        Schema::dropIfExists('asset_request_extensions');
        Schema::dropIfExists('asset_request_events');
        Schema::dropIfExists('asset_request_assets');
        Schema::dropIfExists('asset_asignation_assets');
        Schema::dropIfExists('asset_disincorporation_assets');
        Schema::dropIfExists('asset_inventory_assets');
        Schema::dropIfExists('asset_asignations');
        Schema::dropIfExists('asset_disincorporations');
        Schema::dropIfExists('asset_disincorporation_motives');
        Schema::dropIfExists('asset_rules');
        Schema::dropIfExists('asset_requesteds');
        Schema::dropIfExists('asset_iventory_assets');
        Schema::dropIfExists('asset_inventaries');
        Schema::dropIfExists('asset_inventories');
        Schema::dropIfExists('assets');
        Schema::dropIfExists('asset_required_items');
        Schema::dropIfExists('asset_reports');
        Schema::dropIfExists('asset_specific_categories');
        Schema::dropIfExists('asset_subcategories');
        Schema::dropIfExists('asset_categories');
        Schema::dropIfExists('asset_request_deliveries');
        Schema::dropIfExists('asset_request_prorrogas');
        Schema::dropIfExists('asset_requests');


        Schema::dropIfExists('asset_motive_disincorporations');
        Schema::dropIfExists('asset_types');
        Schema::dropIfExists('asset_uses');
        Schema::dropIfExists('asset_use_functions');
        Schema::dropIfExists('asset_statuses');
        Schema::dropIfExists('asset_status');
        Schema::dropIfExists('asset_conditions');
        Schema::dropIfExists('asset_purchases');
        Schema::dropIfExists('asset_acquisition_types');
        

        /** Genero las migraciones nuevas */
        if (!Schema::hasTable('asset_acquisition_types')) {
            Schema::create('asset_acquisition_types', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('name', 100)->comment('Nombre del tipo de adquisición');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
        if (!Schema::hasTable('asset_conditions')) {
            Schema::create('asset_conditions', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('name', 100)->comment('Nombre de la condición física del bien');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
        if (!Schema::hasTable('asset_status')) {
            Schema::create('asset_status', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('name', 100)->comment('Nombre del estatus de uso');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
        if (!Schema::hasTable('asset_use_functions')) {
            Schema::create('asset_use_functions', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('name', 100)->comment('Nombre de la función de uso');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
        if (!Schema::hasTable('asset_types')) {
            Schema::create('asset_types', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('name', 100)->comment('Nombre del tipo de bien');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');

                $table->unique(['name'])->comment('Clave única para el registro');
            });
        };
        if (!Schema::hasTable('asset_categories')) {
            Schema::create('asset_categories', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('code', 10)->comment('Código de la categoria general');
                $table->string('name', 100)->comment('Nombre de la categoria general del bien');
                
                $table->integer('asset_type_id')->unsigned()->comment('Identificador único del tipo de bien');
                $table->foreign('asset_type_id')->references('id')->on('asset_types')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');

                $table->unique(['asset_type_id', 'code','name'])->comment('Clave única para el registro');
            });
        }
        if (!Schema::hasTable('asset_subcategories')) {
            Schema::create('asset_subcategories', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('code', 10)->comment('Código de la subcategoria');
                $table->string('name', 100)->comment('Nombre de la Subcategoria del bien');

                $table->integer('asset_category_id')->unsigned()
                      ->comment('Identificador del tipo de categoria del bien');
                $table->foreign('asset_category_id')->references('id')->on('asset_categories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');

                $table->unique(['asset_category_id', 'code','name'])->comment('Clave única para el registro');
            });
        }
        if (!Schema::hasTable('asset_specific_categories')) {
            Schema::create('asset_specific_categories', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('code', 10)->comment('Código de la categoria específica');
                $table->string('name', 100)->comment('Nombre de la categoria específica del bien');
                
                $table->integer('asset_subcategory_id')->unsigned()
                      ->comment('Identificador único de la subcategoria a la que pertenece el registro');
                $table->foreign('asset_subcategory_id')->references('id')->on('asset_subcategories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');

                $table->unique(['asset_subcategory_id', 'code','name'])->comment('Clave única para el registro');
            });
        }
        if (!Schema::hasTable('asset_inventories')) {
            Schema::create('asset_inventories', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('code', 20)->unique()->comment('Código identificador del inventario');
                $table->integer('registered')->unsigned()->default(0)->comment('Cantidad de bienes en registrados');
                $table->integer('assigned')->unsigned()->default(0)->comment('Cantidad de bienes en asignados');
                $table->integer('disincorporated')->unsigned()->default(0)
                      ->comment('Cantidad de bienes en desincorporados');
                $table->integer('reserved')->unsigned()->default(0)
                      ->comment('Cantidad de bienes reservados por solicitudes registradas en el sistema');

                /**
                 * Fecha en la que se registra el inventario actual de bienes
                 */
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        };
        if (!Schema::hasTable('asset_requests')) {
            Schema::create('asset_requests', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('code', 20)->unique()->comment('Código identificador de la solicitud');
                $table->integer('type')->nullable()->comment('Identificador único del tipo de solicitud');
                $table->string('motive')->nullable()->comment('Motivo de la solicitud');
                $table->string('state')->nullable()->comment('Estado de la solicitud');
                $table->date('delivery_date')->nullable()->comment('Fecha de entrega');
                $table->string('agent_name')->nullable()->comment('Nombre del agente externo');
                $table->string('agent_telf')->nullable()->comment('Teléfono del agente externo');
                $table->string('agent_email')->nullable()->comment('Correo del agente externo');
                
                $table->integer('user_id')->comment('Identificador único del usuario que realiza la solicitud');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

                /**
                 * Fecha en la que se genera la solicitud
                 */
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
        if (!Schema::hasTable('asset_disincorporation_motives')) {
            Schema::create('asset_disincorporation_motives', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('name', 100)->comment('Nombre del motivo de la desincorporación');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
        if (!Schema::hasTable('asset_disincorporations')) {
            Schema::create('asset_disincorporations', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('code', 20)->unique()->comment('Código identificador de la desincorporación');
                $table->integer('asset_disincorporation_motive_id')->nullable()->unsigned()
                      ->comment('Identificador único del motivo de la desincorporación del bien');
                $table->foreign('asset_disincorporation_motive_id')->references('id')
                      ->on('asset_disincorporation_motives')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->date('date')->nullable()->comment('Fecha de la desincorporación del bien');

                $table->string('observation')->nullable()
                      ->comment('Observaciones generales del estado del bien a desincorporar');

                $table->integer('user_id')->comment('Identificador único del usuario que realiza la desincorporación');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

                /**
                 * Fecha en la que se realiza la desincoporación
                 */
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
        if (!Schema::hasTable('asset_asignations')) {
            Schema::create('asset_asignations', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('code', 20)->unique()->comment('Código identificador de la asignación');

                $table->integer('payroll_staff_id')->nullable()->unsigned()
                      ->comment('Identificador único del trabajador responsable del bien');
                $table->foreign('payroll_staff_id')->references('id')->on('payroll_staffs')
                      ->onDelete('restrict')->onUpdate('cascade');
                
                $table->integer('department_id')->nullable()->unsigned()
                      ->comment('Identificador único del departamento donde recide el bien mueble');
                $table->foreign('department_id')->references('id')->on('departments')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('user_id')->comment('Identificador único del usuario que realiza la asignación');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

                /**
                 * Fecha en la que se realiza la asignación
                **/
                $table->timestamps();

                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
        if (!Schema::hasTable('asset_rules')) {
            Schema::create('asset_rules', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->integer('asset_inventory_id')->unsigned()
                      ->comment('Identificador único del articulo en la tabla de inventario de bienes');
                $table->foreign('asset_inventory_id')->references('id')->on('asset_inventories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('min')->nullable()->unsigned()
                      ->comment('Cantidad minima permitida en el inventario de bienes');

                $table->integer('user_id')->unsigned()
                      ->comment('Identificador único del usuario que realiza el cambio de regla');
                $table->foreign('user_id')->references('id')->on('users')
                      ->onDelete('restrict')->onUpdate('cascade');

                /**
                 * Fecha en que se registra el cambio de regla
                 */
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        };
        if (!Schema::hasTable('assets')) {
            Schema::create('assets', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->integer('asset_type_id')->unsigned()
                      ->comment('Identificador único del tipo de bien (1 Mueble, 2 Inmueble)');
                $table->foreign('asset_type_id')->references('id')->on('asset_types')
                      ->onDelete('restrict')->onUpdate('cascade');
                
                $table->integer('asset_category_id')->unsigned()
                      ->comment('Identificador único de la categoria general a la que pertence el bien');
                $table->foreign('asset_category_id')->references('id')->on('asset_categories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('asset_subcategory_id')->unsigned()
                      ->comment('Identificador único de la subcategoria a la que pertence el bien');
                $table->foreign('asset_subcategory_id')->references('id')->on('asset_subcategories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('asset_specific_category_id')->unsigned()
                      ->comment('Identificador único de la categoria especifica a la que pertence el bien');
                $table->foreign('asset_specific_category_id')->references('id')->on('asset_specific_categories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('asset_condition_id')->nullable()->unsigned()
                      ->comment('Identificador único de la condicion física del bien');
                $table->foreign('asset_condition_id')->references('id')->on('asset_conditions')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('asset_acquisition_type_id')->nullable()->unsigned()
                      ->comment('Identificador único del tipo de adquisicion del bien');
                $table->foreign('asset_acquisition_type_id')->references('id')->on('asset_acquisition_types')
                      ->onDelete('restrict')->onUpdate('cascade');
                
                $table->year('acquisition_year')->nullable()->unsigned()->comment('Año de adquisicion del bien');
                
                $table->integer('asset_status_id')->nullable()->unsigned()
                      ->comment('Identificador único del estatus de uso del bien');
                $table->foreign('asset_status_id')->references('id')->on('asset_status')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('asset_use_function_id')->nullable()->unsigned()
                      ->comment('Identificador único de la función de uso del bien (solo para bienes inmuebles)');
                $table->foreign('asset_use_function_id')->references('id')->on('asset_use_functions')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->string('serial', 50)->nullable()->comment('Serial del fabricante');

                $table->string('marca', 50)->nullable()->comment('Marca del bien');

                $table->string('model', 50)->nullable()->comment('Modelo del bien');

                $table->string('inventory_serial', 50)->nullable()
                      ->comment('Código que coloca el organismo en el bien para identificarlo');

                $table->float('value')->nullable()->unsigned()
                      ->comment('Valor en libros del bien');
                $table->integer('currency_id')->unsigned()->nullable()
                      ->comment('Identificador único asociado a la moneda');
                $table->foreign('currency_id')->references('id')->on('currencies')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->text('specifications')->nullable()->comment('Especificaciones técnicas del bien');
                
                /** Ubicación */
                $table->text('address')->nullable()->comment('Dirección fisíca de bien');
                $table->integer('parish_id')->nullable()->unsigned()
                      ->comment('Identificador único de la parroquia donde esta ubicado el bien');
                $table->foreign('parish_id')->references('id')->on('parishes')
                      ->onDelete('restrict')->onUpdate('cascade');
                
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
        if (!Schema::hasTable('asset_request_assets')) {
            Schema::create('asset_request_assets', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->integer('asset_id')->unsigned()->nullable()
                      ->comment('Identificador único del bien en la tabla de bienes');
                $table->foreign('asset_id')->references('id')->on('assets')->onDelete('restrict')->onUpdate('cascade');

                $table->integer('asset_request_id')->unsigned()->nullable()
                      ->comment('Identificador único de la solicitud generada');
                $table->foreign('asset_request_id')->references('id')->on('asset_requests')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
            });
        }
        if (!Schema::hasTable('asset_request_extensions')) {
            Schema::create('asset_request_extensions', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                
                $table->date('delivery_date')->comment('Nueva fecha de entrega de la solicitud asociada');
                $table->string('state')->nullable()->comment('Estado de la solicitud');
                $table->integer('asset_request_id')
                      ->comment('Identificador único de la solicitud asociada a la prorroga');
                $table->foreign('asset_request_id')->references('id')->on('asset_requests')
                      ->onDelete('restrict')->onUpdate('cascade');
                
                $table->integer('user_id')->comment('Identificador único del usuario que solicita la prorroga');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
        if (!Schema::hasTable('asset_request_events')) {
            Schema::create('asset_request_events', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                
                $table->string('type', 100)->comment('Tipo de evento');
                $table->text('description')->comment('Descripción del evento');
                
                $table->integer('asset_request_id')
                      ->comment('Identificador único de la solicitud asociada al evento en la tabla asset_requests');
                $table->foreign('asset_request_id')->references('id')->on('asset_requests')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
        if (!Schema::hasTable('asset_asignation_assets')) {
            Schema::create('asset_asignation_assets', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->integer('asset_id')->unsigned()->nullable()
                      ->comment('Identificador único del bien en la tabla de bienes');
                $table->foreign('asset_id')->references('id')->on('assets')->onDelete('restrict')->onUpdate('cascade');

                $table->integer('asset_asignation_id')->unsigned()->nullable()
                      ->comment('Identificador único de la asignación generada');
                $table->foreign('asset_asignation_id')->references('id')->on('asset_asignations')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
            });
        }
        if (!Schema::hasTable('asset_disincorporation_assets')) {
            Schema::create('asset_disincorporation_assets', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->integer('asset_id')->unsigned()->nullable()
                      ->comment('Identificador único del bien en la tabla de bienes');
                $table->foreign('asset_id')->references('id')->on('assets')->onDelete('restrict')->onUpdate('cascade');

                $table->integer('asset_disincorporation_id')->unsigned()->nullable()
                      ->comment('Identificador único de la asignación generada');
                $table->foreign('asset_disincorporation_id')->references('id')->on('asset_disincorporations')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
            });
        }
        if (!Schema::hasTable('asset_inventory_assets')) {
            Schema::create('asset_inventory_assets', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->string('asset_condition')->nullable()->comment('Condicion física actual del bien');
                $table->string('asset_status')->nullable()->comment('Estatus de uso actual del bien');
                $table->string('asset_use_function')->nullable()->comment('Función de uso actual del bien');

                $table->integer('asset_id')->unsigned()->nullable()
                      ->comment('Identificador único del bien en la tabla de bienes');
                $table->foreign('asset_id')->references('id')->on('assets')->onDelete('restrict')->onUpdate('cascade');

                $table->integer('asset_inventory_id')->unsigned()->nullable()
                      ->comment('Identificador único del registro de inventario generado');
                $table->foreign('asset_inventory_id')->references('id')->on('asset_inventories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
            });
        }
        if (!Schema::hasTable('asset_request_deliveries')) {
            Schema::create('asset_request_deliveries', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                
                $table->string('state')->nullable()->comment('Estado de la solicitud');
                $table->text('observation')->nullable()->comment('Observaciones de la entrega');
                
                $table->integer('asset_request_id')
                      ->comment('Identificador único de la solicitud asociada a la entrega');
                $table->foreign('asset_request_id')->references('id')->on('asset_requests')
                      ->onDelete('restrict')->onUpdate('cascade');
                
                $table->integer('user_id')->comment('Identificador único del usuario que solicita la entrega');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
            });
        }
        if (!Schema::hasTable('asset_required_items')) {
            Schema::create('asset_required_items', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->boolean('use_function')->default(false)->comment('Define si la función de uso es requerida');
                $table->boolean('serial')->default(false)->comment('Define si el serial es requerido');
                $table->boolean('marca')->default(false)->comment('Define si la marca es requerida');
                $table->boolean('model')->default(false)->comment('Define si el modelo es requerido');
                $table->boolean('address')->default(false)->comment('Define si la dirección es requerida');
                
                $table->integer('asset_specific_category_id')
                      ->comment('Identificador único de la clasificación asociada a los requerimentos');
                $table->foreign('asset_specific_category_id')->references('id')->on('asset_specific_categories')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->unique(['asset_specific_category_id'])->comment('Clave única para el registro');
            });
        }
        if (!Schema::hasTable('asset_reports')) {
            Schema::create('asset_reports', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->string('code', 20)->unique()->comment('Código identificador del reporte');
                
                $table->string('type_report', 20)->nullable()->comment('Tipo de reporte');
                $table->string('type_search', 20)->nullable()->comment('Tipo de búsqueda');

                $table->integer('asset_type_id')->nullable()->unsigned()
                      ->comment('Identificador único del tipo de bien');
                $table->integer('asset_category_id')->nullable()->unsigned()
                      ->comment('Identificador único de la categoria de bien');
                $table->integer('asset_subcategory_id')->nullable()->unsigned()
                      ->comment('Identificador único de la subcategoria de bien');
                $table->integer('asset_specific_category_id')->nullable()->unsigned()
                      ->comment('Identificador único de la categoria especifica de bien');

                $table->integer('department_id')->nullable()->unsigned()
                      ->comment('Identificador único del departamento');
                $table->integer('institution_id')->nullable()->unsigned()
                      ->comment('Identificador único de la institución');

                $table->integer('mes')->nullable()->unsigned()->comment('Identificador único del mes de busqueda');
                $table->year('year')->nullable()->unsigned()->comment('Año de busqueda');

                $table->date('start_date')->nullable()->unsigned()->comment('Fecha inicial de busqueda');
                $table->date('end_date')->nullable()->unsigned()->comment('Fecha final de busqueda');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
    }
}
