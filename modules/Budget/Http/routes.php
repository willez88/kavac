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

    /** Rutas para la configuración general del módulo de presupuesto */
    Route::group(['middleware' => 'permission:budget.setting.create'], function() {
        Route::get('settings', 'BudgetSettingController@index')->name('budget.settings.index');
        Route::post('settings', 'BudgetSettingController@store')->name('budget.settings.store');
    });
    
    /** Rutas para la gestión del clasificador presupuestario */
    Route::resource('accounts', 'BudgetAccountController', ['as' => 'budget', 'except' => ['index', 'show']]);
    Route::get('accounts/vue-list', 'BudgetAccountController@vueList')->name('budget.accounts.vuelist');

    /** Rutas para la gestión de proyectos */
    Route::resource('projects', 'BudgetProjectController', ['as' => 'budget', 'except' => ['index', 'show']]);
    Route::get('projects/vue-list', 'BudgetProjectController@vueList')->name('budget.projects.vuelist');

    /** Rutas para la gestión de acciones centralizadas */
    Route::resource('centralized-actions', 'BudgetCentralizedActionController', [
        'as' => 'budget', 'except' => ['index', 'show']
    ]);
    Route::get('centralized-actions/vue-list', 'BudgetCentralizedActionController@vueList')
         ->name('budget.centralized-actions.vuelist');

    /** Rutas para la gestión de acciones especificas */
    Route::resource('specific-actions', 'BudgetSpecificActionController', [
        'as' => 'budget', 'except' => ['index', 'show']
    ]);
    Route::get('specific-actions/vue-list', 'BudgetSpecificActionController@vueList')
         ->name('budget.specific-actions.vuelist');

    /** Rutas para la gestión de formulación por subespecifica */
    Route::resource('subspecific-formulations', 'BudgetSubSpecificFormulationController', [
        'as' => 'budget', 'except' => ['index', 'show']
    ]);
    Route::get('subspecific-formulations/vue-list', 'BudgetSubSpecificFormulationController@vueList')
         ->name('budget.subspecific-formulations.vuelist');
});
