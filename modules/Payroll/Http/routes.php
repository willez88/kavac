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
    //url por confirmar
    Route::get('get-staffs/list', 'PayrollStaffController@getPayrollStaffs')->name('payroll.get-payroll-staffs');

    Route::resource('instruction-degrees', 'PayrollInstructionDegreeController', ['as' => 'payroll', 'except' => ['show']]);
    //url por confirmar
    Route::get('get-instruction-degrees/list', 'PayrollInstructionDegreeController@getPayrollInstructionDegrees')->name('payroll.get-payroll-instruction-degrees');

    Route::resource('study-types', 'PayrollStudyTypeController', ['as' => 'payroll', 'except' => ['show']]);
    //url por confirmar
    Route::get('get-study-types/list', 'PayrollStudyTypeController@getPayrollStudyTypes')->name('payroll.get-payroll-study-types');

    Route::resource('nationalities', 'PayrollNationalityController', ['as' => 'payroll', 'except' => ['show']]);
    Route::resource('concept-types', 'PayrollConceptTypeController', ['as' => 'payroll', 'except' => ['show']]);


    Route::resource('language-levels', 'PayrollLanguageLevelController', ['as' => 'payroll', 'except' => ['show']]);
    //url por confirmar
    Route::get('get-language-levels/list', 'PayrollLanguageLevelController@getPayrollLanguageLevels')->name('payroll.get-payroll-language-levels');

    Route::resource('languages', 'PayrollLanguageController', ['as' => 'payroll', 'except' => ['show']]);
    //url por confirmar
    Route::get('get-languages/list', 'PayrollLanguageController@getPayrollLanguages')->name('payroll.get-payroll-languages');

    Route::resource('genders', 'PayrollGenderController', ['as' => 'payroll', 'except' => ['show']]);

    Route::resource('socioeconomic-informations', 'PayrollSocioeconomicInformationController', ['as' => 'payroll']);
    Route::get('socioeconomic-informations/show/vue-list', 'PayrollSocioeconomicInformationController@vueList')->name('payroll.socioeconomic-informations.vue-list');
    Route::get('socioeconomic-informations/info/{id}', 'PayrollSocioeconomicInformationController@info')->name('payroll.socioeconomic-informations.info');

    Route::resource('professional-informations', 'PayrollProfessionalInformationController', ['as' => 'payroll']);
    Route::get('professional-informations/info/{id}', 'PayrollProfessionalInformationController@info')->name('payroll.professional-informations.info');
    Route::get('professional-informations/show/vue-list', 'PayrollProfessionalInformationController@vueList')->name('payroll.professional-informations.vue-list');




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
