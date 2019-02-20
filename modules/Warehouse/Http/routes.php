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
    Route::get('attributes/product/{product}', 'WarehouseProductAttributeController@product');
    
    /**
     * ------------------------------------------------------------
     * Rutas para gestionar los Elementos select del Modulo de Almacén
     * ------------------------------------------------------------
     */

    Route::get('vue-list', 'WarehouseController@vueList');
    Route::get('institution/{institution?}', 'WarehouseController@getWarehouse');
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

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar las Solicitudes de Almacén
     * ------------------------------------------------------------
     */

    Route::get('request', 'WarehouseRequestController@index')->name('warehouse.request.index');
    Route::get('request/create', 'WarehouseRequestController@create')->name('warehouse.request.create');
    Route::post('request/store', 'WarehouseRequestController@store')->name('warehouse.request.store');
    Route::get('request/edit/{request}', 'WarehouseRequestController@edit')->name('warehouse.request.edit');
    Route::put('request/update/{request}', 'WarehouseRequestController@update')->name('warehouse.request.update');
    Route::delete('request/delete/{request}', 'WarehouseRequestController@destroy')->name('warehouse.request.destroy');


    

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar Observadores en el Modulo de Almacén
     * ------------------------------------------------------------
     */
    
    /*
     * Ruta para consultar si esta activa la gestión de multiples instituciones en almacen
     */

    Route::get('multi-institution', 'WarehouseController@checkInst');

    /*
     * Ruta para consultar si esta activa la administración de almacenes
     * (para multiples instituciones)
     */

    Route::get('manage', 'WarehouseController@manage');
    
    /**
     * ------------------------------------------------------------
     * Rutas para gestionar los Elementos vue del Modulo de Almacén
     * ------------------------------------------------------------
     */

    /**
     * Rutas para gestionar los Almacenes
     */
    Route::resource('warehouses', 'WarehouseController', ['except' => ['show']]);

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
});


Route::group(['middleware' => 'web', 'namespace' => 'Modules\Warehouse\Http\Controllers'], function()
{
    /*
     * Ruta para finalizar un cierre de almacén dado
     */
    Route::put('warehouse/closes/finish/{close}', 'WarehouseCloseController@close_warehouse');
});