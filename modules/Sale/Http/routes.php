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

        Route::resource(
          'register-quote',
          'SaleQuoteController',
          ['as' => 'sale', 'except' => ['create','edit','show']]
        );

        /**
         * Gestión de los metodos de cobro
         */
        Route::resource(
            'register-charge-money',
            'SaleChargeMoneyController',
            ['as' => 'sale']
        );

        /**
         * Gestión de las formas de cobro
         */
        Route::resource(
            'register-form-payment',
            'SaleFormPaymentController',
            ['as' => 'sale']
        );

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
    Route::resource(
        'setting-deposit',
        'SaleSettingDepositController',
        ['as' => 'sale', 'except' => ['create','edit','show']]
    );
    Route::get(
        'get-setting-deposit',
        'SaleSettingDepositController@getSaleSettingDeposit'
    )->name('sale.get-sale-setting-deposit');

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

    /**
     * -----------------------------------------------------------------------
     * Rutas para la configuración de Descuento
     * -----------------------------------------------------------------------
     *
     * Gestiona los datos de configuración de Descuento de Comercialización
     */
        Route::resource(
            'discount-method',
            'SaleDiscountController',
            ['as' => 'sale', 'except' => ['create','edit','show']]
        );
        Route::get(
            'get-discountmethod',
            'SaleDiscountController@getSaleDiscount'
        )->name('sale.get-sale-paymentmethod');

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar los Ingresos de Almacén
     * ------------------------------------------------------------
     */

        Route::resource('receptions', 'SaleWarehouseReceptionController', ['only' => 'store']);
        Route::patch('receptions/{reception}', 'SaleWarehouseReceptionController@update');
        Route::get('receptions', 'SaleWarehouseReceptionController@index')->name('sale.reception.index');
        Route::get('receptions/create', 'SaleWarehouseReceptionController@create')->name('sale.reception.create');
        Route::get('receptions/info/{reception}', 'SaleWarehouseReceptionController@vueInfo');
        Route::get('receptions/vue-list', 'SaleWarehouseReceptionController@vueList');

        Route::get(
            'receptions/edit/{reception}',
            'SaleWarehouseReceptionController@edit'
        )->name('sale.reception.edit');
        Route::delete(
            'receptions/delete/{reception}',
            'SaleWarehouseReceptionController@destroy'
        )->name('sale.reception.destroy');

        Route::put(
            'receptions/reception-rejected/{reception}',
            'SaleWarehouseReceptionController@rejectedReception'
        );
        Route::put(
            'receptions/reception-approved/{reception}',
            'SaleWarehouseReceptionController@approvedReception'
        );

        /**
         * ------------------------------------------------------------
         * Rutas para gestionar los Elementos select de reportes
         * ------------------------------------------------------------
         */

        Route::get('get-salewarehousemethod/{institution?}', 'SaleWarehouseController@getSaleWarehouseMethod');
        Route::get('get-sale-setting-product/{get-salewarehousemethod}', 'SaleSettingProductController@getSaleSettingProduct');
        Route::get('get-measurement-units', 'SaleWarehouseReceptionController@getMeasurementUnits');

        /**
         * -----------------------------------------------------------------------
         * Rutas para la configuración de Gestión de Pedidos.
         * -----------------------------------------------------------------------
         *
         * Gestiona los datos de configuración de Gestión de Pedidos.
         */
        Route::resource(
            'saleordermanagement-method',
            'SaleOrderManagementController',
            ['as' => 'sale', 'except' => ['create','edit','show']]
        );
        Route::get(
            'get-saleordermanagementmethod',
            'SaleOrderManagementController@getSaleOrderManagementMethod'
        )->name('sale.get-sale-saleordermanagementmethod');
});
