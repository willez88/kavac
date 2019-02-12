<?php
/** Grupo de rutas para el módulo de presupuesto */
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

    /** Rutas para la gestión del clasificador presupuestario */
    Route::resource('accounts', 'BudgetAccountController', ['as' => 'budget', 'except' => ['index', 'show']]);
    Route::get('accounts/vue-list', 'BudgetAccountController@vueList')->name('budget.accounts.vuelist');
    Route::get('accounts/egress-list/{to_formulate?}', 'BudgetAccountController@egressAccounts')
         ->name('budget.accounts.egresslist');
    Route::get('detail-accounts/{id}', 'BudgetAccountController@getDetail')
         ->name('budget.accounts.detail');

    /** Rutas para la gestión de proyectos */
    Route::resource('projects', 'BudgetProjectController', ['as' => 'budget', 'except' => ['index', 'show']]);
    Route::get('projects/vue-list', 'BudgetProjectController@vueList')->name('budget.projects.vuelist');
    Route::get('get-projects/{project_id?}', 'BudgetProjectController@getProjects')->name('budget.get-projects');

    /** Rutas para la gestión de acciones centralizadas */
    Route::resource('centralized-actions', 'BudgetCentralizedActionController', [
        'as' => 'budget', 'except' => ['index', 'show']
    ]);
    Route::get('centralized-actions/vue-list', 'BudgetCentralizedActionController@vueList')
         ->name('budget.centralized-actions.vuelist');
    Route::get(
        'get-centralized-actions/{centralized_action_id?}', 
        'BudgetCentralizedActionController@getCentralizedActions'
    )->name('budget.get-centralized-actions');

    /** Rutas para la gestión de acciones especificas */
    Route::resource('specific-actions', 'BudgetSpecificActionController', [
        'as' => 'budget', 'except' => ['index', 'show']
    ]);
    Route::get('specific-actions/vue-list', 'BudgetSpecificActionController@vueList')
         ->name('budget.specific-actions.vuelist');
    Route::get('get-specific-actions/{type}/{id}', 'BudgetSpecificActionController@getSpecificActions')
         ->name('budget.get-specific-actions');
    Route::get(
        'get-group-specific-actions/{formulated_year?}',
        'BudgetSpecificActionController@getGroupAllSpecificActions'
    )->name('budget.get-specific-actions.groups');
    Route::get('detail-specific-actions/{id}', 'BudgetSpecificActionController@getDetail')
         ->name('budget.specific-actions.detail');

    /** Rutas para la gestión de formulación por subespecifica */
    Route::resource('subspecific-formulations', 'BudgetSubSpecificFormulationController', [
        'as' => 'budget', 'except' => ['show']
    ]);
    Route::get('subspecific-formulations/vue-list', 'BudgetSubSpecificFormulationController@vueList')
         ->name('budget.subspecific-formulations.vuelist');
    Route::get('subspecific-formulations/show/{id}', 'BudgetSubSpecificFormulationController@show')
         ->name('budget.subspecific-formulations.show');
    Route::get('get-subspecific-formulation/{id}', 'BudgetSubSpecificFormulationController@getFormulation')
         ->name('get-formulation');

    /** Rutas para la gestión de créditos adicionales */
    Route::resource('aditional-credits', 'BudgetAditionalCreditController', ['as' => 'budget', 'except' => ['show']]);
    Route::get('aditional-credits/vue-list', 'BudgetAditionalCreditController@vueList')
         ->name('budget.aditional-credits.vuelist');
});
