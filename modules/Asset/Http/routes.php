<?php

/**
 * -----------------------------------------------------------------------
 * Grupo de rutas para la gestión de Bienes Institucionales
 * -----------------------------------------------------------------------
 *
 * Permite gestionar los bienes institucionales y
 * el acceso a los distintos discos establecidos en la configuración de
 *
 */
Route::group(
    ['middleware' => ['web','auth'], 'prefix' => 'asset', 'namespace' => 'Modules\Asset\Http\Controllers'],
    function () {
        Route::get('settings', 'AssetSettingController@index')->name('asset.setting.index');
        Route::post('settings', 'AssetSettingController@store')->name('asset.setting.store');
    
        /**
         * Rutas para gestionar los registros de bienes
         */
        Route::resource('registers', 'AssetController', ['only' => ['store', 'update']]);
        Route::get('registers', 'AssetController@index')->name('asset.register.index');
        Route::get('registers/create', 'AssetController@create')->name('asset.register.create');
        Route::get('registers/edit/{asset}', 'AssetController@edit')->name('asset.register.edit');
        Route::delete('registers/delete/{asset}', 'AssetController@destroy')->name('asset.register.destroy');
        Route::get('registers/info/{asset}', 'AssetController@vueInfo');
        Route::get('registers/vue-list', 'AssetController@vueList')->name('asset.register.vuelist');
        Route::post('registers/search/general', 'AssetController@searchGeneral');
        Route::post('registers/search/clasification', 'AssetController@searchClasification');
        Route::post('registers/search/dependence', 'AssetController@searchDependence');

        /**
         * Rutas para gestionar las asignaciones de bienes institucionales
         */
        Route::resource('asignations', 'AssetAsignationController', ['only' => ['store', 'update']]);
        Route::get('asignations', 'AssetAsignationController@index')
                ->name('asset.asignation.index');
        Route::get('asignations/create', 'AssetAsignationController@create')
                ->name('asset.asignation.create');
        Route::get('asignations/asset/{asset}', 'AssetAsignationController@assetAssign')
                ->name('asset.asignation.asset-assign');
        Route::get('asignations/edit/{asignation}', 'AssetAsignationController@edit')
                ->name('asset.asignation.edit');
    
        Route::delete('asignations/delete/{asignation}', 'AssetAsignationController@destroy')
                ->name('asset.asignation.destroy');
        Route::get('asignations/vue-info/{asignation}', 'AssetAsignationController@vueInfo');
        Route::get('asignations/vue-list', 'AssetAsignationController@vueList');

        /**
         * Rutas para gestionar las desincorporaciones de bienes institucionales
         */
        Route::resource('disincorporations', 'AssetDisincorporationController', ['only' => ['store', 'update']]);
        Route::get('disincorporations', 'AssetDisincorporationController@index')
                ->name('asset.disincorporation.index');
        Route::get('disincorporations/create', 'AssetDisincorporationController@create')
                ->name('asset.disincorporation.create');
        Route::get('disincorporations/asset/{asset}', 'AssetDisincorporationController@assetDisassign')
                ->name('asset.disincorporation.asset-disassign');
        Route::get('disincorporations/edit/{disincorporation}', 'AssetDisincorporationController@edit')
                ->name('asset.disincorporation.edit');
        Route::delete('disincorporations/delete/{disincorporation}', 'AssetDisincorporationController@destroy')
                ->name('asset.disincorporation.destroy');
    
        Route::get('disincorporations/get-motives', 'AssetDisincorporationController@getAssetDisincorporationMotives');
        Route::get('disincorporations/vue-info/{disincorporation}', 'AssetDisincorporationController@vueInfo');
        Route::get('disincorporations/vue-list', 'AssetDisincorporationController@vueList');
    
        /**
         * Rutas para gestionar las solicitudes de bienes institucionales
         */
        Route::resource('requests', 'AssetRequestController', ['only' => ['store', '
        update']]);
        Route::get('requests', 'AssetRequestController@index')->name('asset.request.index');
        Route::get('requests/create', 'AssetRequestController@create')->name('asset.request.create');
        Route::get('requests/edit/{request}', 'AssetRequestController@edit')->name('asset.request.edit');
        Route::delete('requests/delete/{request}', 'AssetRequestController@destroy')->name('asset.request.destroy');
        Route::get('requests/vue-info/{request}', 'AssetRequestController@vueInfo');
        Route::get('requests/vue-list', 'AssetRequestController@vueList');

        /**
         * Rutas para gestionar las solicitudes de equipos pendientes
         */
        Route::get('requests/vue-pending-list', 'AssetRequestController@vuePendingList')
            ->name('asset.request.vuependinglist');
        Route::put('requests/request-approved/{request}', 'AssetRequestController@approved')
            ->name('asset.request.approved');
        Route::put('requests/request-rejected/{request}', 'AssetRequestController@rejected')
            ->name('asset.request.rejected');
    
        /**
         * Rutas para gestionar las solicitudes de prorrogas pendientes
         */
        Route::get('requests/extensions/vue-pending-list', 'AssetRequestExtensionController@vuePendingList')
            ->name('asset.request.extension.vuependinglist');
        Route::put('requests/extensions/request-approved/{request}', 'AssetRequestExtensionController@approved')
            ->name('asset.request.extension.approved');
        Route::put('requests/extensions/request-rejected/{request}', 'AssetRequestExtensionController@rejected')
            ->name('asset.request.extension.rejected');

        /**
         * Rutas para gestionar las solicitudes de entregas pendientes
         */
        Route::put('requests/deliver-equipment/{request}', 'AssetRequestController@deliver')
            ->name('asset.request.deliver');

        Route::resource(
            'requests/deliveries',
            'AssetRequestDeliveryController',
            ['except' => ['show', 'create', 'edit']]
        );

        /**
         * Rutas para gestionar la generación de reportes
         */
        Route::get('inventory-history', 'AssetInventoryController@index')->name('asset.inventory-history.index');
        Route::post('inventory-history', 'AssetInventoryController@store')->name('asset.inventory-history.store');
        Route::get('inventory-history/vue-list', 'AssetInventoryController@vueList')
            ->name('asset.inventory-history.vuelist');
        Route::delete('inventory-history/delete/{code_inventory}', 'AssetInventoryController@destroy')
            ->name('asset.inventory-history.destroy');

        /**
         * Rutas para gestionar la generación de reportes
         */
        Route::resource('reports', 'AssetReportController', ['only' => ['store']]);
        Route::get('reports/show/{code_report}', 'AssetReportController@show')->name('asset.report.show');
        Route::get('reports', 'AssetReportController@index')->name('asset.report.index');

        Route::get('reports/general/show/{code_inventory}', 'AssetReportController@showGeneral')
            ->name('asset.report.general');
        Route::get('reports/clasification/show/{code_inventory}', 'AssetReportController@showClasification')
            ->name('asset.report.clasification');
        Route::get('reports/dependence/show/{code_inventory}', 'AssetReportController@showDependence')
            ->name('asset.report.dependence');

        /**
         * Rutas de uso común del módulo de bienes
         */
        Route::get('get-types', 'AssetTypeController@getTypes');
        Route::get('get-categories/{type?}', 'AssetCategoryController@getCategories');
        Route::get('get-subcategories/{category?}', 'AssetSubcategoryController@getSubcategories');
        Route::get('get-specific-categories/{subcategory?}', 'AssetSpecificCategoryController@getSpecificCategories');

        Route::get('get-required/{specific_category?}', 'AssetSpecificCategoryController@getRequired');

        Route::get('get-acquisition-types', 'AssetAcquisitionTypeController@getAcquisitionTypes');
        Route::get('get-conditions', 'AssetConditionController@getConditions');
        Route::get('get-status', 'AssetStatusController@getStatus');
        Route::get('get-use-functions', 'AssetUseFunctionController@getUseFunctions');

        Route::get('get-staffs', 'ServiceController@getStaffs');
        Route::get('get-type-positions', 'ServiceController@getTypePositions');
        Route::get('get-positions', 'ServiceController@getPositions');

        Route::get('get-request-types', 'AssetRequestController@getTypes');

        /**
         * Rutas para gestionar el panel de control del módulo de bienes
         */
        Route::get('dashboard', 'AssetDashboardController@index');
        Route::get('dashboard/get-inventory-assets/{type}/{order?}', 'AssetDashboardController@getInventoryAssets');
        Route::get('dashboard/get-operation/{type}/{code}', 'AssetDashboardController@getOperation');
        Route::get('dashboard/operations/vue-list', 'AssetDashboardController@vueListOperations');
        Route::get('dashboard/operations/info/{operation}/{created_at}', 'AssetDashboardController@vueInfo');

        /**
         * Rutas para gestionar el clasificador de bienes
         */
        Route::resource('clasifications', 'AssetClasificationController', ['except' => ['show']]);

        /**
         * Rutas para gestionar los tipos de bienes
         */
        Route::resource('types', 'AssetTypeController', ['except' => ['show']]);
    
        /**
         * Rutas para gestionar las categorias de bienes
         */
        Route::resource('categories', 'AssetCategoryController', ['except' => ['show']]);

        /**
         * Rutas para gestionar las subcategorias de bienes
         */
        Route::resource('subcategories', 'AssetSubcategoryController', ['except' => ['show']]);

        /**
         * Rutas para gestionar las Categorias Especificas de bienes
         */
        Route::resource('specific', 'AssetSpecificCategoryController', ['except' => ['show']]);

        /**
         * Rutas para gestionar las condiciones físicas de un bien
         */
        Route::resource('conditions', 'AssetConditionController', ['except' => ['show']]);

        /**
         * Rutas para gestionar los estatus de uso de un bien
         */
        Route::resource('status', 'AssetStatusController', ['except' => ['show']]);

        /**
         * Rutas para gestionar la función de uso de un bien
         */
        Route::resource('use-functions', 'AssetUseFunctionController', ['except' => ['show']]);

        /**
         * Rutas para gestionar el tipo de adquisición de un bien
         */
        Route::resource('acquisition-types', 'AssetAcquisitionTypeController', ['except' => ['show']]);

        /**
         * Rutas para gestionar los eventos ocurridos en bienes solicitados
         */
        Route::resource('requests/request-event', 'AssetRequestEventController', ['except' => ['show']]);

        /**
         * Rutas para gestionar las solicitudes de prorroga de entrega de equipos
         */
        Route::resource('requests/request-extensions', 'AssetRequestExtensionController', ['except' => ['show']]);
    }
);
