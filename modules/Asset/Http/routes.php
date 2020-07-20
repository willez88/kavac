<?php

/**
 * -----------------------------------------------------------------------
 * Grupo de rutas para la gestión de Bienes Institucionales
 * -----------------------------------------------------------------------
 *
 * Permite gestionar los bienes institucionales
 *
 */
Route::group([
    'middleware' => ['web', 'auth', 'verified'],
    'prefix' => 'asset',
    'namespace' => 'Modules\Asset\Http\Controllers'
], function () {

        /** Ruta para visualizar la sección de configuración del módulo */
        Route::get('settings', 'AssetSettingController@index')->name('asset.setting.index');

        /** Ruta para guardar los cambios en la sección de configuración del módulo */
        Route::post('settings', 'AssetSettingController@store')->name('asset.setting.store');

        /**
         * ----------------------------------------------------------
         * Rutas para gestionar el registro de bienes institucionales
         * ----------------------------------------------------------
         */

        /** Rutas para gestionar los registros de bienes */
        Route::resource('registers', 'AssetController', ['only' => ['store', 'update']]);

        /** Ruta que obtiene un listado de los bienes institucionales registrados */
        Route::get('registers', 'AssetController@index')->name('asset.register.index');

        /** Ruta que muestra el formulario para registrar un nuevo bien institucional */
        Route::get('registers/create', 'AssetController@create')->name('asset.register.create');

        /** Ruta que muestra el formulario para actualizar la información de un bien institucional */
        Route::get('registers/edit/{asset}', 'AssetController@edit')->name('asset.register.edit');

        /** Ruta que elimina un bien institucional */
        Route::delete('registers/delete/{asset}', 'AssetController@destroy')->name('asset.register.destroy');

        /** Ruta que obtiene la información de un bien institucional registrado */
        Route::get('registers/info/{asset}', 'AssetController@vueInfo');

        /** Ruta que obtiene un listado de los bienes institucionales */
        Route::get(
            'registers/vue-list/{perPage?}/{page?}/{operation?}/{operation_id?}',
            'AssetController@vueList'
        )->name('asset.register.vuelist');

        /** Ruta que obtiene un listado de los bienes institucionales, de acuerdo al tipo de busqueda general */
        Route::post('registers/search/general', 'AssetController@searchGeneral');

        /** Ruta que obtiene un listado de los bienes institucionales, de acuerdo al tipo de busqueda clasificación */
        Route::post('registers/search/clasification', 'AssetController@searchClasification');

        /** Ruta que obtiene un listado de los bienes institucionales, de acuerdo al tipo de busqueda dependencia */
        Route::post('registers/search/dependence', 'AssetController@searchDependence');

        /** Ruta que permite exportar la información de los bienes institucionales registrados */
        Route::get('registers/export/all', 'AssetController@export');

        /** Ruta que permite importar la información de los bienes institucionales registrados */
        Route::post('registers/import/all', 'AssetController@import');

        /**
         * ---------------------------------------------------------------
         * Rutas para gestionar las asignaciones de bienes institucionales
         * ---------------------------------------------------------------
         */

        /** Rutas para gestionar el registro de asignaciones de bienes */
        Route::resource('asignations', 'AssetAsignationController', ['only' => ['store', 'update']]);

        /** Ruta que obtiene un listado de las asignaciones de bienes institucionales registrados */
        Route::get('asignations', 'AssetAsignationController@index')->name('asset.asignation.index');
        
        /** Ruta que muestra el formulario para registrar una nueva asignación de bienes institucionales */
        Route::get('asignations/create', 'AssetAsignationController@create')->name('asset.asignation.create');

        /** Ruta que muestra el formulario para registrar una nueva asignación de un bien institucional */
        Route::get('asignations/asset/{asset}', 'AssetAsignationController@assetAssign')
             ->name('asset.asignation.asset-assign');

        /** Ruta que muestra el formulario para actualizar la información de una asignación de bienes institucionales */
        Route::get('asignations/edit/{asignation}', 'AssetAsignationController@edit')->name('asset.asignation.edit');

        /** Ruta que elimina una asignación de bienes institucionales */
        Route::delete('asignations/delete/{asignation}', 'AssetAsignationController@destroy')
             ->name('asset.asignation.destroy');

        /** Ruta que obtiene la información de una asignación de bienes institucionales registrada */
        Route::get('asignations/vue-info/{asignation}', 'AssetAsignationController@vueInfo');
        
        /** Ruta que obtiene un listado de las asignacioes de bienes institucionales */
        Route::get('asignations/vue-list', 'AssetAsignationController@vueList');

        /**
         * ---------------------------------------------------------------------
         * Rutas para gestionar las desincorporaciones de bienes institucionales
         * ---------------------------------------------------------------------
         */
        
        /** Rutas para gestionar el registro de desincorporaciones de bienes */
        Route::resource('disincorporations', 'AssetDisincorporationController', ['only' => ['store', 'update']]);

        /** Ruta que obtiene un listado de las desincorporaciones de bienes institucionales registrados */
        Route::get('disincorporations', 'AssetDisincorporationController@index')->name('asset.disincorporation.index');

        /** Ruta que muestra el formulario para registrar una nueva desincorporación de bienes institucionales */
        Route::get('disincorporations/create', 'AssetDisincorporationController@create')
             ->name('asset.disincorporation.create');

        /** Ruta que muestra el formulario para registrar una nueva desincorporación de un bien institucional */
        Route::get('disincorporations/asset/{asset}', 'AssetDisincorporationController@assetDisassign')
             ->name('asset.disincorporation.asset-disassign');

        /** Ruta que muestra el formulario para actualizar la información de una desincorporación */
        Route::get('disincorporations/edit/{disincorporation}', 'AssetDisincorporationController@edit')
             ->name('asset.disincorporation.edit');

        /** Ruta que elimina una desincorporación de bienes institucionales */
        Route::delete('disincorporations/delete/{disincorporation}', 'AssetDisincorporationController@destroy')
             ->name('asset.disincorporation.destroy');

        /** Ruta que obtiene un array con los motivos de una desincorporación registrados */
        Route::get('disincorporations/get-motives', 'AssetDisincorporationController@getAssetDisincorporationMotives');

        /** Ruta que obtiene la información de una desincorporación de bienes institucionales registrada */
        Route::get('disincorporations/vue-info/{disincorporation}', 'AssetDisincorporationController@vueInfo');

        /** Ruta que obtiene un listado de las desincorporaciones de bienes institucionales */
        Route::get('disincorporations/vue-list', 'AssetDisincorporationController@vueList');

        /**
         * --------------------------------------------------------------
         * Rutas para gestionar las solicitudes de bienes institucionales
         * --------------------------------------------------------------
         */

        /** Rutas para gestionar el registro de solicitudes de bienes institucionales */
        Route::resource('requests', 'AssetRequestController', ['only' => ['store', 'update']]);

        /** Ruta que obtiene un listado de las solicitudes de bienes institucionales registrados */
        Route::get('requests', 'AssetRequestController@index')->name('asset.request.index');

        /** Ruta que muestra el formulario para registrar una nueva solicitud de bienes institucionales */
        Route::get('requests/create', 'AssetRequestController@create')->name('asset.request.create');

        /** Ruta que muestra el formulario para actualizar la información de una solicitud */
        Route::get('requests/edit/{request}', 'AssetRequestController@edit')->name('asset.request.edit');

        /** Ruta que elimina una solicitud de bienes institucionales */
        Route::delete('requests/delete/{request}', 'AssetRequestController@destroy')->name('asset.request.destroy');

        /** Ruta que obtiene la información de una solicitud de bienes institucionales registrada */
        Route::get('requests/vue-info/{request}', 'AssetRequestController@vueInfo');

        /** Ruta que obtiene un listado de las solicitudes de bienes institucionales */
        Route::get('requests/vue-list', 'AssetRequestController@vueList');

        /** Ruta que obtiene un array con los equipos institucionaes registrados, de acuerdo con la solicitud */
        Route::get('requests/get-equipments/{request}', 'AssetRequestController@getEquipments');

        /** Ruta que permite cargar documentos */
        Route::post('requests/upload-document', 'AssetRequestEventController@uploadDocument')
             ->name('asset.request.uploadDocument');

        /**
         * ----------------------------------------------------------
         * Rutas para gestionar las solicitudes de equipos pendientes
         * ----------------------------------------------------------
         */

        /** Ruta que obtiene un listado de las solicitudes pendientes de bienes institucionales */
        Route::get('requests/vue-pending-list', 'AssetRequestController@vuePendingList')
             ->name('asset.request.vuependinglist');

        /** Ruta que permite aprobar una solicitud */
        Route::put('requests/request-approved/{request}', 'AssetRequestController@approved')
             ->name('asset.request.approved');

        /** Ruta que permite rechazar una solicitud */
        Route::put('requests/request-rejected/{request}', 'AssetRequestController@rejected')
             ->name('asset.request.rejected');

        /**
         * ------------------------------------------------------------
         * Rutas para gestionar las solicitudes de prorrogas pendientes
         * ------------------------------------------------------------
         */

        /** Ruta que obtiene un listado de las solicitudes de prorroga pendientes */
        Route::get('requests/extensions/vue-pending-list', 'AssetRequestExtensionController@vuePendingList')
             ->name('asset.request.extension.vuependinglist');

        /** Ruta que permite aprobar una solicitud */
        Route::put('requests/extensions/request-approved/{request}', 'AssetRequestExtensionController@approved')
             ->name('asset.request.extension.approved');
        /** Ruta que permite rechazar una solicitud */
        Route::put('requests/extensions/request-rejected/{request}', 'AssetRequestExtensionController@rejected')
             ->name('asset.request.extension.rejected');

        /**
         * -----------------------------------------------------------
         * Rutas para gestionar las solicitudes de entregas pendientes
         * -----------------------------------------------------------
         */
        Route::put('requests/deliver-equipment/{request}', 'AssetRequestController@deliver')
             ->name('asset.request.deliver');

        Route::resource(
            'requests/deliveries',
            'AssetRequestDeliveryController',
            ['except' => ['show', 'create', 'edit']]
        );

        /**
         * ----------------------------------------------
         * Rutas para gestionar la generación de reportes
         * ----------------------------------------------
         */
        Route::get('inventory-history', 'AssetInventoryController@index')->name('asset.inventory-history.index');
        Route::post('inventory-history', 'AssetInventoryController@store')->name('asset.inventory-history.store');
        Route::get('inventory-history/vue-list', 'AssetInventoryController@vueList')
            ->name('asset.inventory-history.vuelist');
        Route::delete('inventory-history/delete/{code_inventory}', 'AssetInventoryController@destroy')
            ->name('asset.inventory-history.destroy');

        /** Rutas para gestionar la generación de reportes */
        Route::resource('reports', 'AssetReportController', ['only' => ['store']]);

        /** Ruta que obtiene la información de un reporte previamente registrado */
        Route::get('reports/show/{code_report}', 'AssetReportController@show')->name('asset.report.show');

        /** Ruta que obtiene un listado de los reportes registrados */
        Route::get('reports', 'AssetReportController@index')->name('asset.report.index');

        /**
         * ---------------------------------------
         * Rutas de uso común del módulo de bienes
         * ---------------------------------------
         */
        
        /** Ruta que obtiene un array con los tipos de bienes registrados */
        Route::get('get-types', 'AssetTypeController@getTypes');

        /** Ruta que obtiene un array con las categorías registradas, de acuerdo al tipo de bien */
        Route::get('get-categories/{type?}', 'AssetCategoryController@getCategories');

        /** Ruta que obtiene un array con las sub-categorías registrados, de acuerdo a la categoría */
        Route::get('get-subcategories/{category?}', 'AssetSubcategoryController@getSubcategories');

        /** Ruta que obtiene un array con las categorías específicas registrados, de acuerdo a la sub-categoría */
        Route::get('get-specific-categories/{subcategory?}', 'AssetSpecificCategoryController@getSpecificCategories');

        /** Ruta que obtiene un array con los requerimentos registrados, de acuerdo a la categía específica */
        Route::get('get-required/{specific_category?}', 'AssetSpecificCategoryController@getRequired');

        /** Ruta que obtiene un array con los tipos de adquisición registrados */
        Route::get('get-acquisition-types', 'AssetAcquisitionTypeController@getAcquisitionTypes');
        
        /** Ruta que obtiene un array con las condiciones fisicas registradas */
        Route::get('get-conditions', 'AssetConditionController@getConditions');
        
        /** Ruta que obtiene un array con los estatus de uso registrados */
        Route::get('get-status', 'AssetStatusController@getStatus');
        
        /** Ruta que obtiene un array con las funciones de uso registradas */
        Route::get('get-use-functions', 'AssetUseFunctionController@getUseFunctions');

        /** Ruta que obtiene un array con el personal registrados */
        Route::get('get-payroll-staffs', 'AssetServiceController@getPayrollStaffs');

        /** Ruta que obtiene un array con los tipos de cargo registrados */
        Route::get('get-payroll-position-types', 'AssetServiceController@getPayrollPositionTypes');

        /** Ruta que obtiene un array con los cargos registrados */
        Route::get('get-payroll-positions', 'AssetServiceController@getPayrollPositions');

        /** Ruta que obtiene un array con los tipos de solicitudes registrados */
        Route::get('get-request-types', 'AssetRequestController@getTypes');

        /**
         * -------------------------------------------------------------
         * Rutas para gestionar el panel de control del módulo de bienes
         * -------------------------------------------------------------
         */
        Route::get('dashboard', 'AssetDashboardController@index');
        Route::get('dashboard/get-inventory-assets/{type}/{order?}', 'AssetDashboardController@getInventoryAssets');
        Route::get('dashboard/get-operation/{type}/{code}', 'AssetDashboardController@getOperation');
        Route::get('dashboard/operations/vue-list', 'AssetDashboardController@vueListOperations');
        Route::get('dashboard/operations/info/{operation}/{created_at}', 'AssetDashboardController@vueInfo');

        /** Rutas para gestionar el clasificador de bienes */
        Route::resource('clasifications', 'AssetClasificationController', ['except' => ['show']]);

        /** Rutas para gestionar los tipos de bienes */
        Route::resource('types', 'AssetTypeController', ['except' => ['show']]);

        /** Rutas para gestionar las categorias de bienes */
        Route::resource('categories', 'AssetCategoryController', ['except' => ['show']]);

        /** Rutas para gestionar las subcategorias de bienes */
        Route::resource('subcategories', 'AssetSubcategoryController', ['except' => ['show']]);

        /** Rutas para gestionar las Categorias Especificas de bienes */
        Route::resource('specific', 'AssetSpecificCategoryController', ['except' => ['show']]);

        /** Rutas para gestionar las condiciones físicas de un bien */
        Route::resource('conditions', 'AssetConditionController', ['except' => ['show']]);

        /** Rutas para gestionar los estatus de uso de un bien */
        Route::resource('status', 'AssetStatusController', ['except' => ['show']]);

        /** Rutas para gestionar la función de uso de un bien */
        Route::resource('use-functions', 'AssetUseFunctionController', ['except' => ['show']]);

        /** Rutas para gestionar el tipo de adquisición de un bien*/
        Route::resource('acquisition-types', 'AssetAcquisitionTypeController', ['except' => ['show']]);

        /** Rutas para gestionar los eventos ocurridos en bienes solicitados */
        Route::resource('requests/request-event', 'AssetRequestEventController', ['except' => ['show']]);

        /** Rutas para gestionar las solicitudes de prorroga de entrega de equipos */
        Route::resource('requests/request-extensions', 'AssetRequestExtensionController', ['except' => ['show']]);
    }
);
