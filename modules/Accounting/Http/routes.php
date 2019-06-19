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
], function(){
	/**
     * Rutas para la gestion de cuentas patrimoniales
     */
	Route::get('accounts', 'AccountingAccountController@index')
			->name('accounting.accounts.index');
	Route::get('get-children-account/{parent_id}', 'AccountingAccountController@getChildrenAccount')
			->name('accounting.accounts.getChildrenAccount');
	Route::resource('accounts', 'AccountingAccountController', 
		['as' => 'accounting',
		'except' => ['index']]);

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
	Route::resource('converter', 'AccountingAccountConverterController', 
		['as' => 'converter',
		'except' => ['index']]);

	/**
     * rutas para la gestión de asientos contables
     */
	Route::get('seating', 'AccountingSeatController@index')
			->name('accounting.seating.index');

	// ruta para crear asientos contables
	Route::post('seating/create', 'AccountingSeatController@create')
			->name('accounting.seating.create');

	// ruta para el filtrado o busqueda de asientos contables aprobados
	Route::post('seating/Filter-Records', 'AccountingSeatController@FilterRecords')
			->name('accounting.seating.FilterRecords');

	// aprobar un asiento contable
	Route::post('seating/approve/{id}', 'AccountingSeatController@approve')
			->name('accounting.seating.approve');

	// ruta para listar los asientos contables no aprobados
	Route::get('seating/unapproved', 'AccountingSeatController@unapproved')
			->name('accounting.seating.unapproved');

	/**
     * rutas para los pdf de asientos contables
     */
	Route::get('seating/pdf/{id}', 'AccountingSeatReportPdfController@pdf')
			->name('accounting.seating.pdf');

	/**
     * rutas para reporte de balance de comprobación
     */
	Route::get('report/BalanceCheckUp','AccountingReportPdfCheckupBalanceController@index')
		->name('accounting.report.BalanceCheckUp');
	Route::get('report/BalanceCheckUp/pdf/{initDate}/{endDate}/{zero?}','AccountingReportPdfCheckupBalanceController@pdf')
		->name('accounting.report.BalanceCheckUp.pdf');

	/**
     * rutas para reporte del Mayor Analítico
     */
	Route::get('report/AnalyticalMajor', 'AccountingReportPdfAnalyticalMajorController@index')
			->name('accounting.report.analyticalMajor');

	Route::post('report/AnalyticalMajor/AccAccount', 'AccountingReportPdfAnalyticalMajorController@getAccAccount')
			->name('accounting.report.analyticalMajor.AccAccount');

	Route::get('report/AnalyticalMajor/pdf/{initAcc}/{endAcc?}', 'AccountingReportPdfAnalyticalMajorController@pdf')
			->name('accounting.report.analyticalMajor.pdf');

	/**
     * rutas para reporte del libro diario
     */
	Route::get('report/diaryBook', 'AccountingReportPdfDailyBookController@index')
			->name('accounting.report.diaryBook');

	Route::get('report/diaryBook/pdf/{initDate}/{endDate}','AccountingReportPdfDailyBookController@pdf')
		->name('accounting.report.diaryBook.pdf');

	/**
	 * rutas para reporte de libro auxiliar
	 */
	Route::get('report/auxiliaryBook', 'AccountingReportPdfAuxiliaryBookController@index')
			->name('accounting.report.auxiliaryBook');
	Route::get('report/auxiliaryBook/pdf/{account_id}/{date}', 'AccountingReportPdfAuxiliaryBookController@pdf')
			->name('accounting.report.auxiliaryBook.pdf');

	/**
	 * rutas para reporte de balance general
	 */
	Route::get('report/balanceSheet', 'AccountingReportPdfBalanceSheetController@index')
			->name('accounting.report.balanceSheet');
	Route::get('report/balanceSheet/pdf/{date}/{level}/{zero?}', 'AccountingReportPdfBalanceSheetController@pdf')
			->name('accounting.report.balanceSheet.pdf');

	/**
	 * rutas para reporte de estado de resultados
	 */
	Route::get('report/stateOfResults', 'AccountingReportPdfStateOfResultsController@index')
			->name('accounting.report.stateOfResults');

	/**
	* rutas de crud de asientos contables
	*/
	Route::resource('seating', 'AccountingSeatController', 
		['as' => 'seating',
		'except' => ['index']]);


	/**
		Rutas para las vistas de configuración de categorias del modulo de contabilidad
	*/
	Route::get('settings', 'AccountingSettingController@index')
			->name('accounting.settings.index');

	Route::post('settings/categories', 'AccountingSettingCategoryController@store')
			->name('accounting.settings.store');

	Route::resource('settings/categories', 'AccountingSettingCategoryController', 
		['as' => 'settings']);

	Route::post('settings/currencies', 'AccountingSettingCurrencyExchangeRateController@storeOrUpdate')
			->name('accounting.settings.storeOrUpdate');


});
