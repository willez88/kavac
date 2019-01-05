<?php

Route::group([
	'middleware' => ['web', 'auth'],
    'prefix' => 'budget', 
	'namespace' => 'Modules\Budget\Http\Controllers'
], function() {
	Route::get('/', 'BudgetController@index')->name('budget.index');

    /** Rutas para la configuración general del módulo de presupuesto */
    Route::group(['middleware' => 'permission:budget.setting.create'], function() {
        Route::get('settings', 'BudgetSettingController@index')->name('budget.settings.index');
        Route::post('settings', 'BudgetSettingController@store')->name('budget.settings.store');
    });

	/** Rutas para la gestión del catálogo de cuentas presupuestarias */
    /*Route::get('accounts', [
        'as' => 'budget.accounts.index',
        'middleware' => 'permission:budget.account.list',
        'uses' => 'BudgetAccountController@index'
    ]);*/
    Route::get('accounts', 'BudgetAccountController@index')->name('budget.accounts.index')
         ->middleware('permission:budget.account.list');
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

    /** Rutas para la gestion de formulaciones */
    Route::get('formulations', 'BudgetFormulationController@index')->name('budget.formulations.index')
         ->middleware('permission:budget.formulation.list');
    Route::get('formulations/create', 'BudgetFormulationController@create')->name('budget.formulations.create')
         ->middleware('permission:budget.formulation.create,budget.account.list');
    Route::post('formulations/store', 'BudgetFormulationController@store')->name('budget.formulations.store')
         ->middleware('permission:budget.formulation.create');
    Route::get('formulations/edit/{formulation}', 'BudgetFormulationController@edit')
         ->name('budget.formulations.edit')->middleware('permission:budget.formulation.edit');
    Route::put('formulations/update/{formulation}', 'BudgetFormulationController@update')
         ->name('budget.formulations.update')->middleware('permission:budget.formulation.edit');
    Route::delete('formulations/delete/{formulation}', 'BudgetFormulationController@destroy')
         ->name('budget.formulations.destroy')->middleware('permission:budget.formulation.delete');
    Route::get('formulations/vue-list', 'BudgetFormulationController@vueList')->name('budget.formulations.vuelist');
});
