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
	* rutas de crud de asientos contables
	*/
	Route::resource('seating', 'AccountingSeatController', 
		['as' => 'seating',
		'except' => ['index']]);

	Route::resource('configuration', 'AccountingconfigurationController', 
		['as' => 'configuration',
		'except' => ['index']]);


});
