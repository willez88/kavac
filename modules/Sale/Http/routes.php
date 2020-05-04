<?php

/**
 * Grupo de rutas para el módulo de Comercialización
 */
Route::group(
    ['middleware' => ['web', 'auth', 'verified'], 'prefix' => 'sale', 'namespace' => 'Modules\Sale\Http\Controllers'],
    function () {
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

<<<<<<< HEAD
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
        'get-settingproduct',
        'SaleSettingProductController@getSaleSettingProduct'
    )->name('sale.get-sale-settingproduct');
    Route::resource(
        'setting-product-type',
        'SaleSettingProductTypeController',
        ['as' => 'sale', 'except' => ['create','edit','show']]
    );
    Route::get(
        'get-settingproducttype',
        'SaleSettingProductTypeController@getSaleSettingProductType'
    )->name('sale.get-sale-settingproducttype');
});
=======
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
    }
);
>>>>>>> 5c732fcb8a1ef17b5d59d4fb66b06c060f1ba4ab
