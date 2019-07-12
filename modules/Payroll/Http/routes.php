<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'payroll', 'namespace' => 'Modules\Payroll\Http\Controllers'], function()
{
    Route::get('/', 'PayrollController@index');

    Route::get('settings', 'PayrollSettingController@index')->name('payroll.settings.index');
    Route::post('settings', 'PayrollSettingController@store')->name('payroll.settings.store');

    Route::resource('staff-types', 'PayrollStaffTypeController', ['as' => 'payroll', 'except' => ['show']]);
    Route::resource('position-types', 'PayrollPositionTypeController', ['as' => 'payroll', 'except' => ['show']]);
    Route::get('get-position-types', 'PayrollPositionTypeController@getPayrollPositionTypes')->name('payroll.get-payroll-position-types');

    Route::resource('positions', 'PayrollPositionController', ['as' => 'payroll', 'except' => ['show']]);
    Route::get('get-positions', 'PayrollPositionController@getPayrollPositions')->name('payroll.get-payroll-positions');

    Route::resource('staff-classifications', 'PayrollStaffClassificationController', ['as' => 'payroll', 'except' => ['show']]);

    Route::resource('staffs', 'PayrollStaffController', ['as' => 'payroll']);
    Route::get('staffs/show/vue-list', 'PayrollStaffController@vueList')->name('payroll.staffs.vue-list');
    //Route::get('staffs/info/{id}', 'PayrollStaffController@info')->name('payroll.staffs.info');
    Route::get('get-staffs', 'PayrollStaffController@getPayrollStaffs')->name('payroll.get-payroll-staffs');

    Route::resource('instruction-degrees', 'PayrollInstructionDegreeController', ['as' => 'payroll', 'except' => ['show']]);
    Route::get('get-instruction-degrees', 'PayrollInstructionDegreeController@getPayrollInstructionDegrees')->name('payroll.get-payroll-instruction-degrees');

    Route::resource('study-types', 'PayrollStudyTypeController', ['as' => 'payroll', 'except' => ['show']]);
    Route::get('get-study-types', 'PayrollStudyTypeController@getPayrollStudyTypes')->name('payroll.get-payroll-study-types');

    Route::resource('nationalities', 'PayrollNationalityController', ['as' => 'payroll', 'except' => ['show']]);
    Route::get('get-nationalities', 'PayrollNationalityController@getPayrollNationalities')->name('payroll.get-payroll-nationalities');

    Route::resource('concept-types', 'PayrollConceptTypeController', ['as' => 'payroll', 'except' => ['show']]);


    Route::resource('language-levels', 'PayrollLanguageLevelController', ['as' => 'payroll', 'except' => ['show']]);
    Route::get('get-language-levels', 'PayrollLanguageLevelController@getPayrollLanguageLevels')->name('payroll.get-payroll-language-levels');

    Route::resource('languages', 'PayrollLanguageController', ['as' => 'payroll', 'except' => ['show']]);
    Route::get('get-languages', 'PayrollLanguageController@getPayrollLanguages')->name('payroll.get-payroll-languages');

    Route::resource('genders', 'PayrollGenderController', ['as' => 'payroll', 'except' => ['show']]);
    Route::get('get-genders', 'PayrollGenderController@getPayrollGenders')->name('payroll.get-payroll-genders');

    Route::resource('socioeconomic-informations', 'PayrollSocioeconomicInformationController', ['as' => 'payroll']);
    Route::get('socioeconomic-informations/show/vue-list', 'PayrollSocioeconomicInformationController@vueList')->name('payroll.socioeconomic-informations.vue-list');
    Route::get('socioeconomic-informations/info/{id}', 'PayrollSocioeconomicInformationController@info')->name('payroll.socioeconomic-informations.info');

    Route::resource('professional-informations', 'PayrollProfessionalInformationController', ['as' => 'payroll']);
    Route::get('professional-informations/show/vue-list', 'PayrollProfessionalInformationController@vueList')->name('payroll.professional-informations.vue-list');
    Route::get('professional-informations/info/{id}', 'PayrollProfessionalInformationController@info')->name('payroll.professional-informations.info');




    /**
     * ------------------------------------------------------------
     * Rutas para gestionar los tabuladores de nómina
     * ------------------------------------------------------------
     */

    Route::resource('salary-tabulators', 'PayrollSalaryTabulatorController', ['except' => ['show']]);

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar las asignaciones de nómina
     * ------------------------------------------------------------
     */

    Route::resource('salary-assignments', 'PayrollSalaryAssignmentController', ['except' => ['show']]);
    Route::resource('salary-assignment-types', 'PayrollSalaryAssignmentTypeController', ['except' => ['show','create','edit']]);
    Route::get('get-salary-assignment-types', 'PayrollSalaryAssignmentTypeController@getAssignmentTypes');

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar los servicios del modulo de nómina
     * ------------------------------------------------------------
     */

    Route::get('get-staffs', 'PayrollServiceController@getStaffs');
    Route::get('get-instruction-degrees', 'PayrollServiceController@getInstructionDegrees');

});
