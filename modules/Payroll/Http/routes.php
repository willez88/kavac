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

    Route::resource('socioeconomic-informations', 'PayrollSocioeconomicInformationController', ['as' => 'payroll', 'except' => ['create', 'edit', 'show']]);
    Route::get('socioeconomic-informations/list', 'PayrollSocioeconomicInformationController@list')->name('payroll.socioeconomic-informations.list');
    Route::get('socioeconomic-informations/marital-status-list', 'PayrollSocioeconomicInformationController@maritalStatusList')->name('payroll.socioeconomic-informations.marital-status-list');
    Route::get('socioeconomic-informations/staffs-list', 'PayrollSocioeconomicInformationController@staffsList')->name('payroll.socioeconomic-informations.staffs-list');

    Route::resource('professional-informations', 'PayrollProfessionalInformationController', ['as' => 'payroll', 'except' => ['create', 'edit', 'show']]);




    /**
     * ------------------------------------------------------------
     * Rutas para gestionar los tabuladores de nómina
     * ------------------------------------------------------------
     */

    Route::resource('tabulators', 'PayrollTabulatorController', ['except' => ['show']]);

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar las asignaciones de nómina
     * ------------------------------------------------------------
     */

    Route::resource('assignments', 'PayrollTabulatorController', ['except' => ['show']]);
    Route::resource('assignment-types', 'PayrollAssignmentTypeController', ['except' => ['show','create','edit']]);

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar el simulador de salario
     * ------------------------------------------------------------
     */

    Route::get('salary-simulator', 'PayrollServiceController@create');
    Route::resource('scales', 'PayrollTabulatorController', ['except' => ['show']]);

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar los servicios del modulo de nómina
     * ------------------------------------------------------------
     */
    
    Route::get('get-staffs', 'PayrollServiceController@getStaffs');
    Route::get('get-position-types', 'PayrollServiceController@getPositionTypes');
    Route::get('get-positions', 'PayrollServiceController@getPositions');
    Route::get('get-assignment-types', 'PayrollServiceController@getAssignmentTypes');
    Route::get('get-instruction-degrees', 'PayrollServiceController@getInstructionDegrees');

});

