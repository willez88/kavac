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

Route::group([
    'middleware' => ['web', 'auth', 'verified'],
    'prefix' => 'purchase',
], function () {
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
    Route::group(['middleware' => 'permission:purchase.setting.create'], function () {

        Route::get('get-fiscal-year', 'PurchaseController@getFiscalYear');

        Route::get('get-institutions', 'PurchaseController@getInstitutions');

        /** Ruta de acceso a parámetros de configuración del módulo */
        Route::get('settings', 'PurchaseSettingController@index')->name('purchase.settings.index');
        Route::post('settings', 'PurchaseSettingController@store')->name('purchase.settings.store');
        /** Rutas para la gestión de objetos de proveedores */
        Route::resource(
            'supplier-objects',
            'PurchaseSupplierObjectController',
            ['as' => 'purchase']
        );
        /** Rutas para la gestión de ramas de proveedores */
        Route::resource(
            'supplier-branches',
            'PurchaseSupplierBranchController',
            ['as' => 'purchase']
        );
        /** Rutas para la gestión de especialidades de proveedores */
        Route::resource(
            'supplier-specialties',
            'PurchaseSupplierSpecialtyController',
            ['as' => 'purchase']
        );
        /** Rutas para la gestión de tipos de proveedores */
        Route::resource('supplier-types', 'PurchaseSupplierTypeController', ['as' => 'purchase']);

        /** Rutas para la gestión de procesos de compras */
        Route::resource('processes', 'PurchaseProcessController', ['as' => 'purchase']);
        Route::get('get-processes', 'PurchaseProcessController@getProcesses');
        Route::post('get-process-documents', 'PurchaseProcessController@getProcessDocuments');
    });

    /*
     * -----------------------------------------------------------------------
     * Rutas para la gestión de tipos de compras
     * -----------------------------------------------------------------------
     *
     * Gestiona los datos de los tipos de compras
     */
    Route::resource('purchase_types', 'PurchaseTypeController', [
        'as'     => 'purchase',
    ]);

    /*
     * -----------------------------------------------------------------------
     * Rutas para la gestión de tipos de contratación
     * -----------------------------------------------------------------------
     *
     * Gestiona los datos de los tipos de contratación
     */
    Route::resource('type_hiring', 'PurchaseTypeHiringController', [
        'as'     => 'purchase',
    ]);

    /*
     * -----------------------------------------------------------------------
     * Rutas para la gestión de tipos de operaciones
     * -----------------------------------------------------------------------
     *
     * Gestiona los datos de los tipos de operaciones
     */
    Route::resource('type_operations', 'PurchaseTypeOperationController', [
        'as'     => 'purchase',
    ]);
    Route::get('get-type-operations', 'PurchaseTypeOperationController@getRecords');

    /*
     * -----------------------------------------------------------------------
     * Rutas para la gestión de proveedores
     * -----------------------------------------------------------------------
     *
     * Gestiona los datos de los proveedores
     */
    Route::resource('suppliers', 'PurchaseSupplierController', ['as' => 'purchase', 'except' => ['show']]);
    Route::get(
        'suppliers/vue-list',
        'PurchaseSupplierController@vueList'
    )->name('purchase.suppliers.vuelist');

    Route::get(
        'get-purchase-supplier-object/{id}',
        'PurchaseSupplierObjectController@getPurchaseSupplierObject'
    );

    /*
     * -----------------------------------------------------------------------
     * Rutas para la gestión de requerimientos
     * -----------------------------------------------------------------------
     *
     * Gestiona los datos de los requerimientos de compras
     */
    Route::post('requirements', 'PurchaseRequirementController@store');

    Route::get('requirements/pdf/{id}', 'Reports\PurchaseRequirementController@pdf');
    
    Route::resource('requirements', 'PurchaseRequirementController', [
        'as'     => 'purchase',
    ]);

    Route::post('base_budget', 'PurchaseBaseBudgetController@store');
    Route::resource('base_budget', 'PurchaseBaseBudgetController', [
        'as'     => 'purchase',
    ]);
    Route::get('requirement-items', 'PurchaseRequirementController@getRequirementItems');

    /*
     * -----------------------------------------------------------------------
     * Rutas para la gestión de planes de compras
     * -----------------------------------------------------------------------
     *
     * Gestiona los datos de los plan de compras
     */
    Route::resource('purchase_plans', 'PurchasePlanController', [
        'as'     => 'purchase',
    ]);
    Route::post('purchase_plans/start_diagnosis', 'PurchasePlanController@uploadFile');

    Route::get('purchase_plans/download/{code}', 'PurchasePlanController@getDownload');
    /*
     * -----------------------------------------------------------------------
     * Rutas para la gestión de ordenes de compras
     * -----------------------------------------------------------------------
     *
     * Gestiona los datos de ordenes de compras
     */
    Route::resource('purchase_order', 'PurchaseOrderController', [
        'as'     => 'purchase',
    ]);
    Route::post('purchase_order/{id}', 'PurchaseOrderController@updatePurchaseOrder');

    /*
     * -----------------------------------------------------------------------
     * Rutas para la gestión de ordenes de compras
     * -----------------------------------------------------------------------
     *
     * Gestiona los datos de ordenes de compras
     */
    Route::resource('direct_hire', 'PurchaseDirectHireController', [
        'as'     => 'purchase',
    ]);
    Route::post('direct_hire/{id}', 'PurchaseDirectHireController@updatePurchaseOrder');


    /*
     * -----------------------------------------------------------------------
     * Rutas para la gestión de cotizaciones
     * -----------------------------------------------------------------------
     *
     * Gestiona los datos de ordenes de compras
     */
    Route::resource('quotation', 'PurchaseQuotationController', [
        'as'     => 'purchase',
    ]);
    Route::post('quotation/{id}', 'PurchaseQuotationController@updatePurchaseQuotation');

    Route::get('get-convertion/{currency_id}/{base_budget_currency_id}', 'PurchaseOrderController@getConvertion');

    /*
     * -----------------------------------------------------------------------
     * Rutas para la gestión de Disponibilidad presupuestaria
     * -----------------------------------------------------------------------
     *
     * Gestiona los datos de los tipos de operaciones
     */
    Route::resource('budgetary_availability', 'PurchaseBudgetaryAvailabilityController', [
        'as'     => 'purchase',
    ]);






    /*
     * -----------------------------------------------------------------------
     * Rutas para la consulta de producto del modulo Warehouse con la informacion de
     * -----------------------------------------------------------------------
     *
     * Gestiona los datos de los tipos de operaciones
     */
    Route::get('get-warehouse-products', 'PurchaseRequirementController@getWarehouseProducts');
});
