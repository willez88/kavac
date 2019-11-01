<?php

Route::group([
    'middleware' => 'web',
    'prefix' => 'citizenservice',
    'namespace' => 'Modules\CitizenService\Http\Controllers'
], function () {
    Route::get('/', 'CitizenServiceController@index');
    Route::get('/settings', function () {
        return view('citizenservice::settings');
    })->name('citizenservice.setting');

    Route::get('/requests/create', 'CitizenServiceRequestController@create')->name('citizenservice.request.create');
    Route::post('/requests/store', 'CitizenServiceRequestController@store')->name('citizenservice.request.store');

    Route::resource(
        'request-types',
        'CitizenServiceRequestTypeController',
        ['as' => 'citizenservice', 'except' => ['create','edit','show']]
    );
    Route::get('/get-request-types', 'CitizenServiceRequestTypeController@getRequestTypes');
});
