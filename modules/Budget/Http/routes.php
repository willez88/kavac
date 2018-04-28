<?php

Route::group([
	'middleware' => ['web', 'auth'],
    'prefix' => 'budget', 
	'namespace' => 'Modules\Budget\Http\Controllers'
], function() {
	Route::get('/', 'BudgetController@index')->name('budget.index');

	/** Rutas para la gestión del catálogo de cuentas presupuestarias */
    /*Route::get('accounts', [
        'as' => 'budget.accounts.index',
        'middleware' => 'permission:budget.account.list',
        'uses' => 'BudgetAccountController@index'
    ]);*/
    Route::get('accounts', 'BudgetAccountController@index')->name('budget.accounts.index')
         ->middleware('permission:budget.account.list');
    Route::get('settings', 'BudgetSettingController@index')->name('budget.settings.index')
         ->middleware('permission:budget.setting.create');
    Route::get('accounts/create', 'BudgetAccountController@create')->name('budget.accounts.create')
         ->middleware('permission:budget.account.create');
    Route::post('accounts/store', 'BudgetAccountController@store')->name('budget.accounts.store')
         ->middleware('permission:budget.account.create');
    Route::get('accounts/edit/{account}', 'BudgetAccountController@edit')->name('budget.accounts.edit')
         ->middleware('permission:budget.account.edit');
    Route::put('accounts/update/{account}', 'BudgetAccountController@update')->name('budget.accounts.update')
         ->middleware('permission:budget.account.edit');
    Route::delete('accounts/delete/{account}', 'BudgetAccountController@destroy')->name('budget.accounts.destroy')
         ->middleware('permission:budget.account.delete');
    Route::get('accounts/vue-list', 'BudgetAccountController@vueList')->name('budget.accounts.vuelist');
});
