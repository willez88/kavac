<?php

/**
 * -----------------------------------------------------------------------
 * Grupo de rutas para la gestión de Almacénes
 * -----------------------------------------------------------------------
 *
 * Permite gestionar los almacenes institucionales
 * 
 */

Route::group(['middleware' => 'web', 'prefix' => 'warehouse', 'namespace' => 'Modules\Warehouse\Http\Controllers'], function()
{
    /*
     * Ruta para acceder al home del Modulo de Almacen
     */

    Route::get('/', 'WarehouseController@index');

    /*
     * Ruta para acceder a la configuración del Modulo de almacén
     */

    Route::get('settings', 'WarehouseSettingController@index')->name('warehouse.setting.index');
    Route::post('settings', 'WarehouseSettingController@store')->name('warehouse.setting.store');
    Route::get('attributes/product/{product}', 'WarehouseProductAttributeController@product');
    
    /**
     * ------------------------------------------------------------
     * Rutas para gestionar los Elementos select del Modulo de Almacén
     * ------------------------------------------------------------
     */

    Route::get('vue-list', 'WarehouseController@vueList');
    Route::get('institution/{institution?}', 'WarehouseController@getWarehouses');
    Route::get('products-list', 'WarehouseProductController@vueList');
    Route::get('units-list', 'WarehouseProductUnitController@vueList');

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar los Ingresos de Almacén
     * ------------------------------------------------------------
     */


    Route::resource('receptions', 'WarehouseReceptionController');
    Route::get('receptions', 'WarehouseReceptionController@index')->name('warehouse.reception.index');
    Route::get('receptions/create', 'WarehouseReceptionController@create')->name('warehouse.reception.create');
    Route::get('reception/edit/{reception}', 'WarehouseReceptionController@edit')->name('warehouse.reception.edit');
    Route::delete('reception/delete/{reception}', 'WarehouseReceptionController@destroy')->name('warehouse.reception.destroy');
    Route::get('receptions/vue-info/{reception}', 'WarehouseReceptionController@vueInfo');

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar los Movimientos de Almacén
     * ------------------------------------------------------------
     */


    Route::resource('movements', 'WarehouseMovementController', ['only' => 'store','update']);
    Route::get('movements', 'WarehouseMovementController@index')->name('
        warehouse.movement.index');
    Route::get('movements/create', 'WarehouseMovementController@create')->name('warehouse.movement.create');
    Route::get('movements/edit/{movement}', 'WarehouseMovementController@edit')->name('warehouse.movement.edit');
    Route::delete('movements/delete/{movement}', 'WarehouseMovementController@destroy')->name('warehouse.movement.destroy');
    Route::get('movements/vue-list-products/{warehouse}/{institution}', 'WarehouseMovementController@vueList');
    Route::get('movements/vue-info/{movement}', 'WarehouseMovementController@vueInfo');

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar las Solicitudes de Almacén
     * ------------------------------------------------------------
     */

    Route::resource('request', 'WarehouseRequestController', ['only' => 'store', 'update']);
    Route::get('request', 'WarehouseRequestController@index')->name('warehouse.request.index');
    Route::get('request/create', 'WarehouseRequestController@create')->name('warehouse.request.create');
    Route::get('request/edit/{request}', 'WarehouseRequestController@edit')->name('warehouse.request.edit');
    Route::delete('request/delete/{request}', 'WarehouseRequestController@destroy')->name('warehouse.request.destroy');

    Route::get('request/vue-info/{request}', 'WarehouseRequestController@vueInfo');

    Route::get('request/vue-list-products', 'WarehouseRequestController@getInventaryProduct');

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar la generación de solicitudes en formato pdf
     * ------------------------------------------------------------
     */

    Route::get('pdf/products/{type}/{product_ware?}', 'WarehousePDFController@createForType');
    Route::get('pdf/{product}/{warehouse}', 'WarehousePDFController@createProduct');

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar la generación de reportes en el Modulo de Almacén
     * ------------------------------------------------------------
     */

    Route::get('report/create', 'WarehouseReportController@create')->name('warehouse.report.create');
    Route::get('report/vue-list/products/{type}/{product?}', 'WarehouseReportController@vueListProduct');
    Route::get('report/vue-list/{product?}/{warehouse?}', 'WarehouseReportController@vueList');

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar Observadores en el Modulo de Almacén
     * ------------------------------------------------------------
     */
    
    /*
     * Ruta para consultar si esta activa la gestión de multiples instituciones en almacen
     */

    Route::get('vue-setting', 'WarehouseSettingController@vueSetting');

    /*
     * Ruta para consultar si esta activa la administración de almacenes
     * (para multiples instituciones)
     */

    Route::get('manage/{warehouse?}', 'WarehouseController@manage');
    
    /**
     * ------------------------------------------------------------
     * Rutas para gestionar los Elementos vue del Modulo de Almacén
     * ------------------------------------------------------------
     */

    /**
     * Rutas para gestionar los Almacenes
     */
    Route::resource('warehouses', 'WarehouseController', ['except' => ['show','index']]);
    Route::get('warehouses/{institution?}', 'WarehouseController@index');

    /**
     * Rutas para gestionar los Cierres de Almacenes
     */
    Route::resource('closes', 'WarehouseCloseController', ['except' => ['show']]);
    
    /**
     * Rutas para gestionar los productos de almacén
     */
    Route::resource('products', 'WarehouseProductController', ['except' => ['show']]);

    /**
     * Rutas para gestionar las características de los productos de almacén
     */
    Route::resource('attributes', 'WarehouseProductAttributeController', ['except' => ['show','edit','create']]);
  	
    /**
     * Rutas para gestionar las Unidades Métrica de almacén
     */
    Route::resource('units', 'WarehouseProductUnitController', ['except' => ['show']]);

    /**
     * Rutas para gestionar las Reglas de Productos de Almacén
     */
    Route::resource('rules', 'WarehouseInventaryRuleController', ['except' => ['show']]);

    Route::get('rules/vue-list-products/{warehouse?}/{institution?}', 'WarehouseInventaryRuleController@vueList');
});


Route::group(['middleware' => 'web', 'namespace' => 'Modules\Warehouse\Http\Controllers'], function()
{
    /*
     * Ruta para finalizar un cierre de almacén dado
     */
    Route::put('warehouse/closes/finish/{close}', 'WarehouseCloseController@close_warehouse');

    Route::put('warehouse/movements-complete/{movement}', 'WarehouseMovementController@approved_movement');

    Route::put('warehouse/request-complete/{request}', 'WarehouseRequestController@approved_request');
});