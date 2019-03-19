<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'payroll', 'namespace' => 'Modules\Payroll\Http\Controllers'], function()
{
    Route::get('/', 'PayrollController@index');

    Route::get('settings', 'PayrollSettingController@index')->name('payroll.settings.index');
    Route::post('settings', 'PayrollSettingController@store')->name('payroll.settings.store');

    Route::resource('staff-types', 'PayrollStaffTypeController', ['except' => ['show']]);
    Route::resource('positions', 'PayrollPositionController', ['except' => ['show']]);
    Route::resource('position-types', 'PayrollPositionTypeController', ['except' => ['show']]);
    Route::resource('staff-classifications', 'PayrollStaffClassificationController', ['except' => ['show']]);
    Route::resource('staffs', 'PayrollStaffController');

    Route::resource('instruction-degrees', 'PayrollInstructionDegreeController', ['except' => ['show']]);
    Route::resource('study-types', 'PayrollStudyTypeController', ['except' => ['show']]);
    Route::resource('nationalities', 'PayrollNationalityController', ['except' => ['show']]);
    Route::resource('concept-types', 'PayrollConceptTypeController', ['except' => ['show']]);
});
