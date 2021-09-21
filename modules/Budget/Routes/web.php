<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Grupo de rutas para el módulo de presupuesto
 */
Route::group(
    [
        'middleware' => ['web', 'auth', 'verified'],
        'prefix' => 'budget',
    ],
    function () {
        /**
         * -----------------------------------------------------------------------
         * Ruta para el panel de control del módulo de presupuesto
         * -----------------------------------------------------------------------
         *
         * Muestra información del módulo de presupuesto
         */
        Route::get(
            '/',
            'BudgetController@index'
        )->name('budget.index');

        /**
         * -----------------------------------------------------------------------
         * Rutas para la configuración general del módulo de presupuesto
         * -----------------------------------------------------------------------
         *
         * Gestiona los datos de configuración del módulo de presupuesto
         */
        Route::group(
            ['middleware' => 'permission:budget.setting.create'],
            function () {
                Route::get('settings', 'BudgetSettingController@index')->name('budget.settings.index');
                Route::post('settings', 'BudgetSettingController@store')->name('budget.settings.store');
            }
        );

        /**
         * -----------------------------------------------------------------------
         * Rutas para la gestión del clasificador presupuestario
         * -----------------------------------------------------------------------
         *
         * Gestiona los datos del clasificador de cuentas presupuestarias
         */
        Route::get(
            'accounts',
            'BudgetAccountController@index'
        )->name('budget.accounts.index')->middleware('permission:budget.account.list');
        Route::resource('accounts', 'BudgetAccountController', ['as' => 'budget', 'except' => ['index', 'show']]);
        Route::get('accounts/vue-list', 'BudgetAccountController@vueList')->name('budget.accounts.vuelist');
        Route::get(
            'accounts/egress-list/{to_formulate?}',
            'BudgetAccountController@egressAccounts'
        )->name('budget.accounts.egresslist');
        Route::get(
            'detail-accounts/{id}',
            'BudgetAccountController@getDetail'
        )->name('budget.accounts.detail');
        Route::get(
            'set-children-account/{parent_id}',
            'BudgetAccountController@setChildrenAccount'
        )->name('budget.set-parent-account');

        /**
         * -----------------------------------------------------------------------
         * Rutas para la gestión de proyectos
         * -----------------------------------------------------------------------
         *
         * Gestiona los datos de los proyectos
         */
        Route::resource('projects', 'BudgetProjectController', ['as' => 'budget', 'except' => ['index', 'show']]);
        Route::get(
            'projects/vue-list/{active?}',
            'BudgetProjectController@vueList'
        )->name('budget.projects.vuelist');
        Route::get('get-projects/{project_id?}', 'BudgetProjectController@getProjects')->name('budget.get-projects');

        /**
         * -----------------------------------------------------------------------
         * Rutas para la gestión de acciones centralizadas
         * -----------------------------------------------------------------------
         *
         * Gestiona los datos de las acciones centralizadas
         */
        Route::resource(
            'centralized-actions',
            'BudgetCentralizedActionController',
            [
                'as' => 'budget', 'except' => ['index', 'show']
            ]
        );
        Route::get(
            'centralized-actions/vue-list/{active?}',
            'BudgetCentralizedActionController@vueList'
        )->name('budget.centralized-actions.vuelist');
        Route::get(
            'get-centralized-actions/{centralized_action_id?}',
            'BudgetCentralizedActionController@getCentralizedActions'
        )->name('budget.get-centralized-actions');

        /**
         * -----------------------------------------------------------------------
         * Rutas para la gestión de acciones especificas
         * -----------------------------------------------------------------------
         *
         * Gestiona los datos de las acciones específicas
         */
        Route::resource(
            'specific-actions',
            'BudgetSpecificActionController',
            [
                'as' => 'budget', 'except' => ['index', 'show']
            ]
        );
        Route::get(
            'specific-actions/vue-list/{active?}',
            'BudgetSpecificActionController@vueList'
        )->name('budget.specific-actions.vuelist');
        Route::get(
            'get-specific-actions/{type}/{id}/{source?}',
            'BudgetSpecificActionController@getSpecificActions'
        )->name('budget.get-specific-actions');
        Route::get(
            'get-group-specific-actions/{formulated_year?}/{formulated?}/{institution_id?}',
            'BudgetSpecificActionController@getGroupAllSpecificActions'
        )->name('budget.get-specific-actions.groups');
        Route::get(
            'detail-specific-actions/{id}',
            'BudgetSpecificActionController@getDetail'
        )->name('budget.specific-actions.detail');

        /**
         * -----------------------------------------------------------------------
         * Rutas para la gestión de formulación por subespecifica
         * -----------------------------------------------------------------------
         *
         * Gestiona los datos de las formulaciones de presupuesto por subespecífica.
         * La formulación del presupuesto se realiza mediante las acciones específicas
         * de proyectos y acciones centralizadas
         */
        Route::resource(
            'subspecific-formulations',
            'BudgetSubSpecificFormulationController',
            [
                'as' => 'budget', 'except' => ['show']
            ]
        );
        Route::get(
            'subspecific-formulations/vue-list',
            'BudgetSubSpecificFormulationController@vueList'
        )->name('budget.subspecific-formulations.vuelist');
        Route::get(
            'subspecific-formulations/show/{id}',
            'BudgetSubSpecificFormulationController@show'
        )->name('budget.subspecific-formulations.show');
        Route::get(
            'get-subspecific-formulation/{id}',
            'BudgetSubSpecificFormulationController@getFormulation'
        )->name('get-formulation');
        Route::get(
            'get-availability-opened-accounts/{specific_action_id}/{account_id}',
            'BudgetSubSpecificFormulationController@getAvailabilityOpenedAccounts'
        )->name('get-availability-opened-accounts');
        Route::post(
            'get-import-formulation',
            'BudgetSubSpecificFormulationController@importFormulation'
        )->name('import.formulation');
        Route::get(
            'print-formulated/{id}',
            'BudgetSubSpecificFormulationController@printFormulated'
        )->name('print.formulated');
        Route::get('reports/download', 'BudgetSubSpecificFormulationController@download');

        /**
         * -----------------------------------------------------------------------
         * Rutas para la gestión de modificaciones presupuestarias
         * -----------------------------------------------------------------------
         *
         * Gestiona los datos de las modificaciones presupuestarias (créditos adicionales,
         * reducciones y/o traspasos)
         */
        Route::get('modifications', 'BudgetModificationController@index')->name('budget.modifications.index');
        Route::get(
            'modifications/{type}',
            'BudgetModificationController@create'
        )->name('budget.modifications.create');
        Route::post(
            'modifications',
            'BudgetModificationController@store'
        )->name('budget.modifications.store');
        Route::get(
            'modifications/{type}/{modification}/edit',
            'BudgetModificationController@edit'
        )->name('budget.modifications.edit');
        Route::put(
            'modifications/{modification}',
            'BudgetModificationController@update'
        )->name('budget.modifications.update');
        Route::delete(
            'modifications/{modification}',
            'BudgetModificationController@destroy'
        )->name('budget.modifications.destroy');
        Route::get(
            'modifications/vue-list/{type}',
            'BudgetModificationController@vueList'
        )->name('budget.modifications.vuelist');

        /**
         * -----------------------------------------------------------------------
         * Rutas para la gestión de compromisos presupuestarios
         * -----------------------------------------------------------------------
         *
         * Gestiona los datos de las modificaciones presupuestarias (créditos adicionales,
         * reducciones y/o traspasos)
         */
        Route::resource('compromises', 'BudgetCompromiseController', ['as' => 'budget']);
        Route::get(
            'compromises/vue-list',
            'BudgetCompromiseController@vueList'
        )->name('budget.compromises.vuelist');
        Route::get(
            'compromises/get-document-sources/{institution_id}/{year}',
            'BudgetCompromiseController@getDocumentSources',
        )->name('budget.compromises.get-document-sources');

        /**
         * -----------------------------------------------------------------------
         * Rutas para la gestión de cuentas formuladas y aperturadas
         * -----------------------------------------------------------------------
         *
         * Gestiona los datos de las cuentas aperturadas para la ejecución del presupuesto
         */
        Route::get(
            'get-opened-accounts/{specificActionId}/{selDate?}',
            'BudgetSpecificActionController@getOpenedAccounts'
        )->name('budget.opened-accounts.get');

        /**
         * -----------------------------------------------------------------------
         * Rutas para los reportes presupuestarios
         * -----------------------------------------------------------------------
         *
         */

        Route::group(['prefix' => 'report'], function () {
            Route::get('/budgetAvailibity', 'Reports\BudgetReportsController@budgetAvailability')->name('budget.report.budgetAvailability');

            Route::get('/budgetAvailibityPdf', 'Reports\BudgetReportsController@getPdf')->name('budget.report.budgetAvailabilityPdf');

            Route::get('/projects', 'Reports\BudgetReportsController@getProjectsView')->name('budget.report.projects');
            Route::get('/projects-report', 'Reports\BudgetReportsController@getProjectsReportData')->name('budget.report.projects.data');
            Route::get('/projects-report-pdf', 'Reports\BudgetReportsController@getProjectsReportPdf')->name('budget.report.projects.pdf');

            Route::get('/formulated', 'Reports\BudgetReportsController@getFormulatedView')->name('budget.report.formulated');
            Route::get('/formulations', 'Reports\BudgetReportsController@getFormulations')->name('budget.formulations');
            Route::get('/formulated-report', 'Reports\BudgetReportsController@getFormulatedReportData')->name('budget.report.formulated.data');
            Route::get('/formulated-report-pdf', 'Reports\BudgetReportsController@getFormulatedReportPdf')->name('budget.report.formulated.pdf');
        });
    }
);
