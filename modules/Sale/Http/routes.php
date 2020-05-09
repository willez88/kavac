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
            'payment-method',
            'SalePaymentMethodController',
            ['as' => 'sale', 'except' => ['create','edit','show']]
        );
        Route::get(
            'get-paymentmethod',
            'SalePaymentMethodController@getSalePaymentMethod'
        )->name('sale.get-sale-paymentmethod');
    }
);
