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
 * -----------------------------------------------------------------------------
 * Grupo de rutas para la gestión de Soporte Técnico
 * -----------------------------------------------------------------------------
 *
 * Permite gestionar las operaciones realizadas en el módulo de soporte técnico.
 *
 */
Route::group([
    'middleware' => ['web', 'auth', 'verified'],
    'prefix' => 'technicalsupport',
], function () {

    /**
     * -------------------------------------------------------------------------
     * Rutas de uso general dentro del módulo de soporte técnico
     * -------------------------------------------------------------------------
     */
    Route::get('/', 'TechnicalSupportController@index');
    Route::get('/get-technicalsupport-staff', 'TechnicalSupportController@getTechnicalSupportStaff');

    /**
     * -------------------------------------------------------------------------
     * Rutas para gestionar la configuración general del módulo.
     * -------------------------------------------------------------------------
     */
    Route::get('/settings', 'TechnicalSupportSettingController@index')->name('technicalsupport.setting.index');

    /**
     * -------------------------------------------------------------------------
     * Rutas para gestionar las reparaciones de avería de bienes institucionales.
     * -------------------------------------------------------------------------
     */
    Route::resource(
        'repairs',
        'TechnicalSupportRepairController',
        ['as' => 'technicalsupport', 'except' => ['show']]
    );
    Route::get('/repairs/vue-list', 'TechnicalSupportRepairController@vueList');
    Route::get('/repairs/vue-info/{repair}', 'TechnicalSupportRepairController@vueInfo');

    /**
     * -------------------------------------------------------------------------
     * Rutas para gestionar las reparaciones de avería de bienes institucionales.
     * -------------------------------------------------------------------------
     */
    Route::resource(
        'repair-diagnostics',
        'TechnicalSupportDiagnosticController',
        ['as' => 'technicalsupport', 'except' => ['show', 'create', 'edit', 'destroy']]
    );

    Route::get('repair-diagnostics/{repair}', 'TechnicalSupportDiagnosticController@create')
        ->name('technicalsupport.repair-diagnostics.create');

    Route::get('repair-diagnostics/asset/{asset}', 'TechnicalSupportDiagnosticController@index')
        ->name('technicalsupport.repair-diagnostics.index-diagnostic');
    Route::post('repair-diagnostics/asset/{asset}', 'TechnicalSupportDiagnosticController@strore')
        ->name('technicalsupport.repair-diagnostics.store-diagnostic');

    /**
     * -------------------------------------------------------------------------
     * Rutas para gestionar las solicitudes de reparación de averías de bienes
     * institucionales.
     * -------------------------------------------------------------------------
     */
    Route::resource(
        'requests',
        'TechnicalSupportRequestController',
        ['as' => 'technicalsupport', 'except' => ['show']]
    );
    Route::get('/requests/vue-list', 'TechnicalSupportRequestController@vueList')
        ->name('technicalsupport.requests.vue-list');
    Route::get('/requests/vue-info/{request}', 'TechnicalSupportRequestController@vueInfo')
        ->name('technicalsupport.requests.vue-info');
});
