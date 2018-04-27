<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'budget', 'namespace' => 'Modules\Budget\Http\Controllers'], function()
{
	Route::get('/', 'BudgetController@index')->name('budget.index');
    Route::get('accounts', 'BudgetAccountController@index')->name('budget.accounts.index');
    Route::get('accounts/create', 'BudgetAccountController@create')->name('budget.accounts.create');
    Route::post('accounts/store', 'BudgetAccountController@store')->name('budget.accounts.store');
    Route::get('accounts/vue-list', 'BudgetAccountController@vueList')->name('budget.accounts.vuelist');
    Route::delete('accounts/delete/{account}', 'BudgetAccountController@destroy')->name('budget.accounts.destroy');
});
