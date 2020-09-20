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
 * -----------------------------------------------------------------------
 * Grupo de rutas para la gestión de Almacénes
 * -----------------------------------------------------------------------
 *
 * Permite gestionar los almacenes institucionales
 *
 */

Route::group(['middleware' => ['web', 'auth', 'verified'], 'prefix' => 'warehouse'], function () {
    /*
     * Ruta para acceder al home del Modulo de Almacen
     */

    Route::get('/', 'WarehouseController@index');

    /*
     * Ruta para acceder a la configuración del Modulo de almacén
     */

    Route::get('settings', 'WarehouseSettingController@index')->name('warehouse.setting.index');
    Route::post('settings', 'WarehouseSettingController@store')->name('warehouse.setting.store');
    Route::post(
        'setting-parameters',
        'WarehouseSettingController@storeParameter'
    )->name('warehouse.setting-parameter.store');

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar los Elementos select del Modulo de Almacén
     * ------------------------------------------------------------
     */

    Route::get('get-warehouses/{institution?}', 'WarehouseController@getWarehouses');
    Route::get('get-warehouse-products', 'WarehouseProductController@getWarehouseProducts');
    Route::get('get-warehouse-product/{product}', 'WarehouseProductController@getProductMeasurementUnit');
    Route::get('attributes/product/{product}', 'WarehouseProductController@getProductAttributes');
    Route::get('get-measurement-units', 'WarehouseProductController@getMeasurementUnits');

    /*
     * Rutas para los elementos requeridos del módulo de nomina
     */
    Route::get('get-payroll-staffs', 'WarehouseServiceController@getPayrollStaffs');
    Route::get('get-payroll-positions', 'WarehouseServiceController@getPayrollPositions');

    /*
     * Rutas para los elementos requeridos del módulo de presupuesto
     */
    Route::get('get-budget-projects/{project_id?}', 'WarehouseServiceController@getBudgetProjects');
    Route::get(
        'get-budget-centralized-actions/{centralized_action_id?}',
        'WarehouseServiceController@getBudgetCentralizedActions'
    );
    Route::get(
        'get-budget-specific-actions/{type}/{id}/{source?}',
        'WarehouseServiceController@getBudgetSpecificActions'
    );

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar los Ingresos de Almacén
     * ------------------------------------------------------------
     */


    Route::resource('receptions', 'WarehouseReceptionController', ['only' => 'store']);
    Route::patch('receptions/{reception}', 'WarehouseReceptionController@update');
    Route::get('receptions', 'WarehouseReceptionController@index')->name('warehouse.reception.index');
    Route::get('receptions/create', 'WarehouseReceptionController@create')->name('warehouse.reception.create');
    Route::get('receptions/info/{reception}', 'WarehouseReceptionController@vueInfo');
    Route::get('receptions/vue-list', 'WarehouseReceptionController@vueList');

    Route::get(
        'receptions/edit/{reception}',
        'WarehouseReceptionController@edit'
    )->name('warehouse.reception.edit');
    Route::delete(
        'receptions/delete/{reception}',
        'WarehouseReceptionController@destroy'
    )->name('warehouse.reception.destroy');

    Route::put(
        'receptions/reception-rejected/{reception}',
        'WarehouseReceptionController@rejectedReception'
    );
    Route::put(
        'receptions/reception-approved/{reception}',
        'WarehouseReceptionController@approvedReception'
    );


    /**
     * ------------------------------------------------------------
     * Rutas para gestionar los Movimientos de Almacén
     * ------------------------------------------------------------
     */


    Route::resource('movements', 'WarehouseMovementController', ['only' => 'store']);
    Route::patch('movements/{movement}', 'WarehouseMovementController@update');
    Route::get('movements', 'WarehouseMovementController@index')->name('warehouse.movement.index');
    Route::get('movements/create', 'WarehouseMovementController@create')->name('warehouse.movement.create');
    Route::get('movements/edit/{movement}', 'WarehouseMovementController@edit')->name('warehouse.movement.edit');
    Route::get('movements/info/{movement}', 'WarehouseMovementController@vueInfo');

    Route::delete(
        'movements/delete/{movement}',
        'WarehouseMovementController@destroy'
    )->name('warehouse.movement.destroy');
    Route::get('movements/vue-list', 'WarehouseMovementController@vueList');
    Route::get(
        'movements/vue-list-products/{warehouse}/{institution}',
        'WarehouseMovementController@vueListProducts'
    );

    Route::put(
        'movements/movement-rejected/{movement}',
        'WarehouseMovementController@rejectedMovement'
    );
    Route::put(
        'movements/movement-approved/{reception}',
        'WarehouseMovementController@approvedMovement'
    );

    Route::put('movements/movement-complete/{movement}', 'WarehouseMovementController@confirmMovement');

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar las Solicitudes de Almacén
     * ------------------------------------------------------------
     */

    Route::resource('requests', 'WarehouseRequestController', ['only' => 'store']);
    Route::patch('requests/{requests}', 'WarehouseRequestController@update');
    Route::get('requests', 'WarehouseRequestController@index')->name('warehouse.request.index');
    Route::get('requests/create', 'WarehouseRequestController@create')->name('warehouse.request.create');
    Route::get('requests/edit/{request}', 'WarehouseRequestController@edit')->name('warehouse.request.edit');
    Route::delete(
        'requests/delete/{request}',
        'WarehouseRequestController@destroy'
    )->name('warehouse.request.destroy');

    Route::get('requests/vue-list', 'WarehouseRequestController@vueList');
    Route::get('requests/vue-pending-list', 'WarehouseRequestController@vuePendingList');
    Route::get('requests/info/{request}', 'WarehouseRequestController@vueInfo');
    Route::get('requests/vue-list-products', 'WarehouseRequestController@getInventoryProduct');

    Route::get(
        'requests/staff/vue-list',
        'WarehouseRequestStaffController@vueList'
    )->name('warehouse.request.staff.vue-list');
    Route::get('requests/staff/info/{request}', 'WarehouseRequestStaffController@vueInfo');
    Route::get('requests/staff/create', 'WarehouseRequestStaffController@create')
        ->name('warehouse.request.staff.create');
    Route::get('requests/staff/edit/{request}', 'WarehouseRequestStaffController@edit')
        ->name('warehouse.request.staff.edit');
    Route::resource(
        'requests/staff',
        'WarehouseRequestStaffController',
        ['as' => 'warehouse.request', 'only' => ['store', 'update']]
    );

    Route::put('requests/request-complete/{request}', 'WarehouseRequestController@confirmRequest');
    Route::put('requests/request-rejected/{request}', 'WarehouseRequestController@rejectedRequest');
    Route::put('requests/request-approved/{request}', 'WarehouseRequestController@approvedRequest');

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar la generación de solicitudes en formato pdf
     * ------------------------------------------------------------
     */

    Route::get('pdf/products/{type}/{product_ware?}', 'WarehousePDFController@createForType');
    Route::get('pdf/warehouse/{warehouse}/product/{product}', 'WarehousePDFController@create');
    Route::get('pdf/warehouse-products', 'WarehousePDFController@createWarehouseProducts');
    Route::get('pdf/product/{product}', 'WarehousePDFController@createForProduct');
    Route::get('pdf/warehouse/{warehouse}', 'WarehousePDFController@createForWarehouse');


    /**
     * ------------------------------------------------------------
     * Rutas para gestionar la generación de reportes en el Modulo de Almacén
     * ------------------------------------------------------------
     */

    Route::get('reports/inventory-products', 'WarehouseReportController@inventoryProducts')
        ->name('warehouse.report.inventory-products');
    Route::get('reports/request-products', 'WarehouseReportController@requestProducts')
        ->name('warehouse.report.request-products');
    Route::get('reports/stocks', 'WarehouseReportController@stocks')
        ->name('warehouse.report.stocks');
    Route::post('reports/inventory-products/vue-list', 'WarehouseReportController@vueList');
    Route::post('reports/inventory-products/create', 'WarehouseReportController@create');

    Route::get('report/show/{code}', 'WarehouseReportController@show');

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
     * Rutas para gestionar el panel de control del Modulo de Almacén
     * ------------------------------------------------------------
     */
    Route::get(
        'get-warehouse-inventory-products/{type}/{order?}',
        'WarehouseProductController@getInventoryProducts'
    );
    Route::get('dashboard', 'WarehouseDashboardController@index');
    Route::get('dashboard/operations/vue-list', 'WarehouseDashboardController@vueListOperations');
    Route::get('dashboard/get-operation/{type_report}/{code}', 'WarehouseDashboardController@getOperation');
    Route::get('dashboard/vue-list-min-products', 'WarehouseDashboardController@vueListMinProducts');
    Route::get('dashboard/operations/info/{operation}/{created_at}', 'WarehouseDashboardController@vueInfo');

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar los Elementos vue del Modulo de Almacén
     * ------------------------------------------------------------
     */

    /**
     * Rutas para gestionar los Almacenes
     */
    Route::resource('warehouses', 'WarehouseController', ['except' => 'show']);
    Route::get('institution/{institution?}', 'WarehouseController@index');

    /**
     * Rutas para gestionar los Cierres de Almacenes
     */
    Route::resource('closes', 'WarehouseCloseController', ['except' => ['show']]);

    /**
     * Rutas para gestionar los productos de almacén
     */
    Route::resource('products', 'WarehouseProductController', ['except' => ['show']]);
    Route::get('products/export/all', 'WarehouseProductController@export');
    Route::post('products/import/all', 'WarehouseProductController@import');

    /**
     * Rutas para gestionar las Reglas de Productos de Almacén
     */
    Route::resource('rules', 'WarehouseInventoryRuleController', ['except' => ['show']]);

    Route::get('rules/vue-list-products/{warehouse?}/{institution?}', 'WarehouseInventoryRuleController@vueList');
});


Route::group(['middleware' => 'web'], function () {
    /*
     * Ruta para finalizar un cierre de almacén dado
     */
    Route::put('warehouse/closes/finish/{close}', 'WarehouseCloseController@closeWarehouse');
});
