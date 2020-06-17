<?php

Route::group([
    'middleware' => ['web', 'auth', 'verified'],
    'prefix' => 'citizenservice',
    'namespace' => 'Modules\CitizenService\Http\Controllers'
], function () {
    Route::get('/', 'CitizenServiceController@index');
    /*Route::get('/settings', function () {
        return view('citizenservice::settings');
    })->name('citizenservice.setting');
    */
    Route::get('settings', 'CitizenServiceSettingController@index')->name('citizenservice.settings.index');
    Route::post('settings', 'CitizenServiceSettingController@store')->name('citizenservice.settings.store');
   
   /* Ruta para solicitudes*/
    Route::resource('requests', 'CitizenServiceRequestController', ['only' => ['update']]);

    Route::get('/requests/create', 'CitizenServiceRequestController@create')->name('citizenservice.request.create');
    Route::post('/requests', 'CitizenServiceRequestController@store')->name('citizenservice.request.store');
    Route::get('/requests', 'CitizenServiceRequestController@index')->name('citizenservice.request.index');
    Route::get('requests/edit/{request}', 'CitizenServiceRequestController@edit')->name('citizenservice.request.edit');
    Route::delete('/requests/delete/{request}', 'CitizenServiceRequestController@destroy')
        ->name('citizenservice.request.delete');
    Route::get('requests/vue-list', 'CitizenServiceRequestController@vueList');
    Route::get('requests/vue-info/{request}', 'CitizenServiceRequestController@vueInfo');
    Route::get('requests/vue-pending-list', 'CitizenServiceRequestController@vueListPending');
    Route::get('requests/vue-list-closing', 'CitizenServiceRequestController@vueListClosing');
  

    Route::put('requests/request-approved/{request}', 'CitizenServiceRequestController@approved');
    Route::put('requests/request-rejected/{request}', 'CitizenServiceRequestController@rejected');

    /* Ruta para tipos de solicitudes */
    Route::resource(
        'request-types',
        'CitizenServiceRequestTypeController',
        ['as' => 'citizenservice', 'except' => ['create','edit','show']]
    );
    Route::get('/get-request-types', 'CitizenServiceRequestTypeController@getRequestTypes');

    /* Ruta para tipo de departamentos */
    Route::resource(
        'departments',
        'CitizenServiceDepartmentController',
        ['as' => 'citizenservice', 'except' => ['create','edit','show']]
    );
    Route::get('/get-departments', 'CitizenServiceDepartmentController@getCitizenServiceDepartments');
    
   
    Route::resource(
        'request-close',
        'CitizenServiceRequestCloseController',
        ['as' => 'citizenservice', 'except' => ['create','edit','show']]
    );
    Route::get('requests/vue-close/{id}', 'CitizenServiceRequestCloseController@vueClose');
    Route::post('requests/validate-document', 'CitizenServiceRequestCloseController@store');

    /**
     * Rutas para generar reporte
     */
    Route::get('reports', 'CitizenServiceReportController@index')->name('citizenservice.report.index');
    
    Route::post('reports', 'CitizenServiceReportController@store');
    
    Route::post('reports/search/period', 'CitizenServiceReportController@searchPeriod');
    Route::post('reports/search/date', 'CitizenServiceReportController@searchDate');

    /**
     * Rutas para generar registro de actividades
     */
    
    Route::resource('registers', 'CitizenServiceRegisterController', ['only' => ['update']]);
    
    Route::get('/registers/create', 'CitizenServiceRegisterController@create')->name('citizenservice.register.create');

    Route::get('register', 'CitizenServiceRegisterController@index')->name('citizenservice.register.index');

    Route::post('registers', 'CitizenServiceRegisterController@store');

    Route::get('registers/edit/{register}', 'CitizenServiceRegisterController@edit')->name('citizenservice.register.edit');
    
    Route::delete('/registers/delete/{register}', 'CitizenServiceRegisterController@destroy')->name('citizenservice.register.delete');
    
    Route::get('registers/vue-list', 'CitizenServiceRegisterController@vueList');
    
    Route::get('registers/vue-info/{register}', 'CitizenServiceRegisterController@vueInfo');
});
