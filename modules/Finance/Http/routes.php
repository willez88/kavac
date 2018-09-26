<?php

Route::group([
	'middleware' => ['web', 'auth'],
	'prefix' => 'finance',
	'namespace' => 'Modules\Finance\Http\Controllers'
], function() {
    Route::get('/', 'FinanceController@index')->name('finance.index');
});
