<?php

Route::group([
	'middleware' => ['web', 'auth'], 
	'prefix' => 'purchase', 
	'namespace' => 'Modules\Purchase\Http\Controllers'
], function() {
	/*
     * -----------------------------------------------------------------------
     * Ruta para el panel de control del módulo de compras
     * -----------------------------------------------------------------------
     *
     * Muestra información del módulo de compras
     */
    Route::get('/', 'PurchaseController@index')->name('purchase.index');

    /*
     * -----------------------------------------------------------------------
     * Rutas para la configuración general del módulo de compras
     * -----------------------------------------------------------------------
     *
     * Gestiona los datos de configuración del módulo de compras
     */
    Route::group(['middleware' => 'permission:purchase.setting.create'], function() {
    	/** Ruta de acceso a parámetros de configuración del módulo */
        Route::get('settings', 'PurchaseSettingController@index')->name('purchase.settings.index');
        Route::post('settings', 'PurchaseSettingController@store')->name('purchase.settings.store');
        /** Rutas para la gestión de objetos de proveedores */
        Route::resource(
            'supplier-objects', 'PurchaseSupplierObjectController', ['as' => 'purchase']
        );
        /** Rutas para la gestión de ramas de proveedores */
        Route::resource(
            'supplier-branches', 'PurchaseSupplierBranchController', ['as' => 'purchase']
        );
        /** Rutas para la gestión de especialidades de proveedores */
        Route::resource(
        	'supplier-specialties', 'PurchaseSupplierSpecialtyController', ['as' => 'purchase']
        );
        /** Rutas para la gestión de tipos de proveedores */
        Route::resource('supplier-types', 'PurchaseSupplierTypeController', ['as' => 'purchase']);
    });
    
    /*
     * -----------------------------------------------------------------------
     * Rutas para la gestión de proveedores
     * -----------------------------------------------------------------------
     *
     * Gestiona los datos de los proveedores
     */
    Route::resource('suppliers', 'PurchaseSupplierController', ['as' => 'purchase', 'except' => ['show']]);
    Route::get(
        'suppliers/vue-list', 'PurchaseSupplierController@vueList'
    )->name('purchase.suppliers.vuelist');
});
