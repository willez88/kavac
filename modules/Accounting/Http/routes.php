<?php

Route::group(['middleware' => 'web',
			  'prefix' => 'accounting',
			  'namespace' => 'Modules\Accounting\Http\Controllers'
], function(){
	// Rutas para la gestion de cuentas patrimoniales
	Route::get('accounts', 'AccountingAccountController@index')->name('accounting.accounts.index');

	Route::resource('accounts', 'AccountingAccountController', 
		['as' => 'accounting',
		'except' => ['index']]);
	Route::get('get-children-account/{parent_id}', 'AccountingAccountController@getChildrenAccount')->name('accounting.accounts.getChildrenAccount');
});
