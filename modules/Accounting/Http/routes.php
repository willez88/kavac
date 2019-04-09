<?php

Route::group(['middleware' => 'web',
			  'prefix' => 'accounting',
			  'namespace' => 'Modules\Accounting\Http\Controllers'
], function(){
	// Rutas para la gestion de cuentas patrimoniales
	Route::get('accounts', 'AccountingAccountController@index')->name('accounting.accounts.index');
	Route::get('get-children-account/{parent_id}', 'AccountingAccountController@getChildrenAccount')->name('accounting.accounts.getChildrenAccount');
	Route::resource('accounts', 'AccountingAccountController', 
		['as' => 'accounting',
		'except' => ['index']]);


	// Rutoas para las operaciones de conversión de cuentas
	Route::get('converter', 'AccountingAccountConverterController@index')->name('accounting.converter.index');
	Route::post('converter/create', 'AccountingAccountConverterController@create')->name('accounting.converter.create');
	Route::post('converter/get-Records', 'AccountingAccountConverterController@getRecords')->name('accounting.converter.getRecords');
	Route::resource('converter', 'AccountingAccountConverterController', 
		['as' => 'converter',
		'except' => ['index']]);


	// rutas para la gestión de asientos contables
	Route::get('seating', 'AccountingSeatController@index')->name('accounting.seating.index');
	Route::resource('seating', 'AccountingSeatController', 
		['as' => 'seating',
		'except' => ['index']]);
});
