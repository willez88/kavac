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
    Route::get('/', 'WarehouseController@index');

    Route::get('settings', 'WarehouseSettingController@index')->name('warehouse.setting.index');

    Route::put('closes/end/{close}', 'WarehouseCloseController@endClose')->name('warehouse.close.end');
    Route::get('vue-list', 'WarehouseController@vueList');
    /*
     * Ruta para consultar si esta activa la gentión de multiples instituciones en almacen
     */
    Route::get('multi-institution', 'WarehouseController@checkInst');
    Route::get('manage', 'WarehouseController@manage');

    

    Route::post('products/attribute/{product}', 'WarehouseProductController@newAttribute');

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
     * Rutas para gestionar las Unidades Métrica de almacén
     */
    Route::resource('units', 'WarehouseProductUnitController', ['except' => ['show']]);

    /**
     * Rutas para gestionar las Reglas de Productos de Almacén
     */
    Route::resource('rules', 'WarehouseInventaryRuleController', ['except' => ['show']]);
});
