<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'payroll', 'namespace' => 'Modules\Payroll\Http\Controllers'], function()
{
    Route::get('/', 'PayrollController@index');

    Route::get('settings', 'PayrollSettingController@index')->name('payroll.settings.index');
    Route::post('settings', 'PayrollSettingController@store')->name('payroll.settings.store');

    Route::resource('staff-types', 'PayrollStaffTypeController', ['as' => 'payroll', 'except' => ['show']]);
    Route::resource('position-types', 'PayrollPositionTypeController', ['as' => 'payroll', 'except' => ['show']]);
    Route::resource('positions', 'PayrollPositionController', ['as' => 'payroll', 'except' => ['show']]);
    Route::resource('staff-classifications', 'PayrollStaffClassificationController', ['as' => 'payroll', 'except' => ['show']]);
    Route::resource('staffs', 'PayrollStaffController', ['as' => 'payroll']);

    Route::resource('instruction-degrees', 'PayrollInstructionDegreeController', ['as' => 'payroll', 'except' => ['show']]);
    Route::resource('study-types', 'PayrollStudyTypeController', ['as' => 'payroll', 'except' => ['show']]);
    Route::resource('nationalities', 'PayrollNationalityController', ['as' => 'payroll', 'except' => ['show']]);
    Route::resource('concept-types', 'PayrollConceptTypeController', ['as' => 'payroll', 'except' => ['show']]);
    Route::resource('language-levels', 'PayrollLanguageLevelController', ['as' => 'payroll', 'except' => ['show']]);
    Route::resource('languages', 'PayrollLanguageController', ['as' => 'payroll', 'except' => ['show']]);
    Route::resource('genders', 'PayrollGenderController', ['as' => 'payroll', 'except' => ['show']]);
    Route::resource('socioeconomic-informations', 'PayrollSocioeconomicInformationController', ['as' => 'payroll']);
});
