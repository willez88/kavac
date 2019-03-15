<?php

Route::group(['middleware' => 'web',
			  'prefix' => 'accounting',
			  'namespace' => 'Modules\Accounting\Http\Controllers'
], function(){
    // Route::get('/', 'AccountingController@index')->name('accounting.index');
    Route::prefix('accounts')->group(function () {
	    Route::get('index', 'AccountingAccountController@index')->name('accounts.index');
	});
});
