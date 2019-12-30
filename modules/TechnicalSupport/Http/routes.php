<?php

/**
 * -----------------------------------------------------------------------
 * Grupo de rutas para la gestión de Soporte Técnico
 * -----------------------------------------------------------------------
 *
 * Permite gestionar las operaciones realizadas en el módulo de soporte técnico.
 *
 */
Route::group([
    'middleware' => ['web', 'auth', 'verified'],
    'prefix' => 'technicalsupport',
    'namespace' => 'Modules\TechnicalSupport\Http\Controllers'
], function () {
    Route::get('/', 'TechnicalSupportController@index');

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar la configuración general del módulo.
     * ------------------------------------------------------------
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

    Route::get('/repairs/requests/vue-list', 'TechnicalSupportRequestRepairController@index')
        ->name('technicalsupport.request-repair.index');

    Route::get('/repairs/requests/vue-info/{request}', 'TechnicalSupportRequestRepairController@vueInfo')
        ->name('technicalsupport.request-repair.vue-info');

    Route::post('/repairs/assign-repair-manager', 'TechnicalSupportRequestRepairController@store');

    Route::get('/get-technicalsupport-staff', 'TechnicalSupportController@getTechnicalSupportStaff');
});
