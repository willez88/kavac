<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Grupo de rutas para el módulo de Comercialización
 */
Route::group(['middleware' => ['web', 'auth', 'verified'], 'prefix' => 'sale'], function () {
    /**
     * -----------------------------------------------------------------------
     * Ruta para el panel de control del módulo de Comercialización
     * -----------------------------------------------------------------------
     *
     * Muestra información del módulo de Comercialización
     */
    Route::get('settings', 'SaleSettingController@index')->name('sale.settings.index');
    //Route::post('settings', 'SaleSettingController@store')->name('sale.settings.store');

    /**
     * -----------------------------------------------------------------------
     * Rutas para la configuración general del módulo de Comercialización
     * -----------------------------------------------------------------------
     *
     * Gestiona los datos de configuración del módulo de Comercialización
     */
    Route::resource(
        'register-clients',
        'SaleClientsController',
        ['as' => 'sale', 'except' => ['create','edit','show']]
    );

    Route::resource(
        'register-formatcode',
        'SaleCodeFormatController',
        ['as' => 'sale', 'except' => ['create','edit','show']]
    );

    Route::resource(
        'payment-method',
        'SalePaymentMethodController',
        ['as' => 'sale', 'except' => ['create','edit','show']]
    );
    Route::get(
        'get-paymentmethod',
        'SalePaymentMethodController@getSalePaymentMethod'
    )->name('sale.get-sale-paymentmethod');


    /**
     * -----------------------------------------------------------------------
     * Rutas para la configuración general del módulo de Comercialización
     * -----------------------------------------------------------------------
     *
     * Gestiona los datos de configuración del módulo de Comercialización
     */
    Route::resource(
        'payment-method',
        'SalePaymentMethodController',
        ['as' => 'sale', 'except' => ['create','edit','show']]
    );
    Route::get(
        'get-paymentmethod',
        'SalePaymentMethodController@getSalePaymentMethod'
    )->name('sale.get-sale-paymentmethod');
    Route::resource(
        'setting-product',
        'SaleSettingProductController',
        ['as' => 'sale', 'except' => ['create','edit','show']]
    );
    Route::get(
        'get-setting-product',
        'SaleSettingProductController@getSaleSettingProduct'
    )->name('sale.get-sale-setting-product');
    Route::resource(
        'setting-product-type',
        'SaleSettingProductTypeController',
        ['as' => 'sale', 'except' => ['create','edit','show']]
    );
    Route::get(
        'get-setting-product-type',
        'SaleSettingProductTypeController@getSaleSettingProductType'
    )->name('sale.get-sale-setting-product-type');

    /**
     * -----------------------------------------------------------------------
     * Rutas para la configuración de Almacen de Comercialización
     * -----------------------------------------------------------------------
     *
     * Gestiona los datos de configuración de Almacen de Comercialización
     */
    Route::resource(
        'warehouse-method',
        'SaleWarehouseController',
        ['as' => 'sale', 'except' => ['create','edit','show']]
    );
    Route::get(
        'get-salewarehousemethod',
        'SaleWarehouseController@getSaleWarehouseMethod'
    )->name('sale.get-sale-warehousemethod');
});
