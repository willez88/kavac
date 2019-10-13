<?php

/**
 * -----------------------------------------------------------------------
 * Grupo de rutas para la gestión de cuentas patrimoniales, conversiones, asientos contables y reportes
 * -----------------------------------------------------------------------
 *
 * Permite gestionar las cuentas patrimoniales, asientos contables y generar reportes
 *
 */
Route::group(['middleware' => 'web',
              'prefix' => 'accounting',
              'namespace' => 'Modules\Accounting\Http\Controllers'
], function () {

    /**
     * Rutas temporal para la visualizacion del dashboard del modulo de contabilidad
     */
    Route::get('', 'AccountingDashboardController@index', ['as'=>'accounting'])->name('accounting.dashboard.test');

    /**
    * Ruta del dashboard para consultar ultimas operaciones en el modulo
    */
    Route::post('lastOperations', 'AccountingDashboardController@getOperations', ['as'=>'accounting'])
    ->name('accounting.dashboard.last_operations');

    Route::post('get_report_histories', 'AccountingDashboardController@getReportHistories', ['as'=>'accounting'])
    ->name('accounting.dashboard.report_histories');

    /**
     * Rutas para la gestion de cuentas patrimoniales
     */
    Route::get('accounts', 'AccountingAccountController@index')
            ->name('accounting.accounts.index');

    Route::get('get-children-account/{parent_id}', 'AccountingAccountController@getChildrenAccount')
            ->name('accounting.accounts.getChildrenAccount');

    Route::post('import', 'AccountingAccountController@import')
            ->name('accounting.accounts.import');

    Route::post('importedAccounts', 'AccountingAccountController@registerImportedAccounts')
            ->name('accounting.accounts.registerImportedAccounts');

    Route::resource(
        'accounts',
        'AccountingAccountController',
        ['as' => 'accounting',
        'except' => ['index']]
    );

    /**
     * Rutas para las operaciones de conversión de cuentas
     */
    Route::get('converter', 'AccountingAccountConverterController@index')
            ->name('accounting.converter.index');

    // retorna cuenta patrimonial asociada
    Route::get('converter/budgetToAccount/{id}', 'AccountingAccountConverterController@budgetToAccount')
            ->name('accounting.converter.budgetToAccount');

    // retorna cuenta presupuestal asociada
    Route::get('converter/accountToBudget/{id}', 'AccountingAccountConverterController@accountToBudget')
            ->name('accounting.converter.accountToBudget');

    Route::post('converter/create', 'AccountingAccountConverterController@create')
            ->name('accounting.converter.create');

    Route::post('converter/get-Records', 'AccountingAccountConverterController@getRecords')
            ->name('accounting.converter.getRecords');

    Route::post(
        'converter/getAllRecordsAccounting_vuejs',
        'AccountingAccountConverterController@getAllRecordsAccountingVuejs'
    )->name('accounting.converter.getAllRecordsAccounting_vuejs');
            
    Route::post(
        'converter/getAllRecordsBudget_vuejs',
        'AccountingAccountConverterController@getAllRecordsBudgetVuejs'
    )->name('accounting.converter.getAllRecordsBudget_vuejs');



    Route::resource(
        'converter',
        'AccountingAccountConverterController',
        ['as' => 'converter',
        'except' => ['index']]
    );


    /**
     * ruta para listar los asientos contables no aprobados
     */
    Route::get('entries/unapproved', 'AccountingEntryController@unapproved')
            ->name('accounting.entries.unapproved');
    /**
     * rutas para la gestión de asientos contables
     */
    Route::resource(
        'entries',
        'AccountingEntryController',
        ['as' => 'entries']
    );
    Route::get('entries', 'AccountingEntryController@index')
            ->name('accounting.entries.index');

    /**
     * ruta para crear asientos contables
     */
    Route::post('entries/create', 'AccountingEntryController@create')
            ->name('accounting.entries.create');

    /**
     * ruta para el filtrado o busqueda de asientos contables aprobados
     */
    Route::post('entries/Filter-Records', 'AccountingEntryController@FilterRecords')
            ->name('accounting.entries.FilterRecords');

    /**
     * aprobar un asiento contable
     */
    Route::post('entries/approve/{id}', 'AccountingEntryController@approve')
            ->name('accounting.entries.approve');

    /**
     * rutas para los pdf de asientos contables
     */
    Route::get('entries/pdf/{id}', 'Reports\AccountingEntryController@pdf')
            ->name('accounting.entries.pdf');


    /**
    * Rutas index para los formularios de los reportes
    */

    Route::get('report/accountingBooks', 'Reports\AccountingReportsController@accountingBooks')
        ->name('accounting.report.accountingBooks');

    Route::get('report/financeStatements', 'Reports\AccountingReportsController@financeStatements')
        ->name('accounting.report.financeStatements');







    /**
     * rutas para reporte de balance de comprobación
     */
    Route::get('report/balanceCheckUp/pdf/{initDate}/{endDate}/{currency}/{all?}', 'Reports\AccountingCheckupBalanceController@pdf')
        ->name('accounting.report.BalanceCheckUp.pdf');

    /**
     * rutas para reporte del Mayor Analítico
     */
    Route::post('report/analyticalMajor/AccAccount', 'Reports\AccountingAnalyticalMajorController@getAccAccount')
            ->name('accounting.report.analyticalMajor.AccAccount');

    Route::get(
        'report/analyticalMajor/pdf/{initDate}/{endDate}/{initAcc}/{endAcc}/{currency}',
        'Reports\AccountingAnalyticalMajorController@pdf'
    )->name('accounting.report.analyticalMajor.pdf');

    /**
     * rutas para reporte del libro diario
     */
    Route::get('report/dailyBook/pdfVue/{initDate}/{endDate}/{currency}', 'Reports\AccountingDailyBookController@pdfVue')
        ->name('accounting.report.dailyBook.pdf');

    Route::get('report/dailyBook/pdf/{initDate}/{endDate}/{currency}', 'Reports\AccountingDailyBookController@pdf');

    /**
     * rutas para reporte de libro auxiliar
     */
    Route::get('report/auxiliaryBook/pdf/{account_id}/{date}/{currency}', 'Reports\AccountingAuxiliaryBookController@pdf')
            ->name('accounting.report.auxiliaryBook.pdf');

    /**
     * rutas para reporte de balance general
     */
    Route::get('report/balanceSheet/pdf/{date}/{level}/{currency}/{zero?}', 'Reports\AccountingBalanceSheetController@pdf')
            ->name('accounting.report.balanceSheet.pdf');

    /**
     * rutas para reporte de estado de resultados
     */
    Route::get('report/stateOfResults/pdf/{date}/{level}/{currency}/{zero?}', 'Reports\AccountingStateOfResultsController@pdf')
            ->name('accounting.report.stateOfResults.pdf');

    /**
        Rutas para las vistas de configuración de categorias del modulo de contabilidad
    */
    Route::get('settings', 'AccountingSettingController@index')
            ->name('accounting.settings.index');
    Route::post('settings/code', 'AccountingSettingController@code_store')
            ->name('accounting.settings.code.store');
    Route::post('settings/generate_reference_code', 'AccountingSettingController@generate_reference_code')
            ->name('accounting.settings.code.generate');


    Route::resource(
        'settings/categories',
        'AccountingSettingCategoryController',
        ['as' => 'accounting']
    );

    Route::get('get-categories/', 'AccountingSettingCategoryController@getCategories');
});
