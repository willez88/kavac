<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'budget', 'namespace' => 'Modules\Budget\Http\Controllers'], function()
{
	Route::get('/', 'BudgetController@index')->name('budget.index');
    Route::resource('accounts', 'BudgetAccountController', ['as' => 'budget']); // ['as' => 'nombre-del-modulo']
});
