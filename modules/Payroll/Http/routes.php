<?php

Route::group([
    'middleware' => ['web', 'auth', 'verified'],
    'prefix' => 'payroll',
    'namespace' => 'Modules\Payroll\Http\Controllers'
], function () {

    //Route::get('', 'PayrollController@index', ['as'=>'payroll'])->name('payroll.index');

    Route::get('settings', 'PayrollSettingController@index')->name('payroll.settings.index');
    Route::post('settings', 'PayrollSettingController@store')->name('payroll.settings.store');

    Route::resource(
        'work-age-settings',
        'PayrollWorkAgeSettingController',
        ['as' => 'payroll', 'except' => ['index','create','edit','show','destroy']]
    );

    Route::resource(
        'staff-types',
        'PayrollStaffTypeController',
        ['as' => 'payroll', 'except' => ['create','edit','show']]
    );
    Route::get(
        'get-staff-types',
        'PayrollStaffTypeController@getPayrollStaffTypes'
    )->name('payroll.get-payroll-staff-types');

    Route::resource(
        'position-types',
        'PayrollPositionTypeController',
        ['as' => 'payroll', 'except' => ['create','edit','show']]
    );
    Route::get(
        'get-position-types',
        'PayrollPositionTypeController@getPayrollPositionTypes'
    )->name('payroll.get-payroll-position-types');

    Route::resource(
        'positions',
        'PayrollPositionController',
        ['as' => 'payroll', 'except' => ['create','edit','show']]
    );
    Route::get(
        'get-positions',
        'PayrollPositionController@getPayrollPositions'
    )->name('payroll.get-payroll-positions');

    Route::resource(
        'staff-classifications',
        'PayrollStaffClassificationController',
        ['as' => 'payroll', 'except' => ['create','edit','show']]
    );
    Route::get(
        'get-staff-classifications',
        'PayrollStaffClassificationController@getPayrollStaffClassifications'
    )->name('payroll.get-payroll-staff-classifications');

    Route::resource('staffs', 'PayrollStaffController', ['as' => 'payroll']);
    Route::get('staffs/show/vue-list', 'PayrollStaffController@vueList')->name('payroll.staffs.vue-list');
    Route::get('get-staffs', 'PayrollStaffController@getPayrollStaffs')->name('payroll.get-payroll-staffs');

    Route::resource(
        'instruction-degrees',
        'PayrollInstructionDegreeController',
        ['as' => 'payroll', 'except' => ['show']]
    );
    Route::get(
        'get-instruction-degrees',
        'PayrollInstructionDegreeController@getPayrollInstructionDegrees'
    )->name('payroll.get-payroll-instruction-degrees');

    Route::resource(
        'study-types',
        'PayrollStudyTypeController',
        ['as' => 'payroll', 'except' => ['create','edit','show']]
    );
    Route::get(
        'get-study-types',
        'PayrollStudyTypeController@getPayrollStudyTypes'
    )->name('payroll.get-payroll-study-types');

    Route::resource('nationalities', 'PayrollNationalityController', ['as' => 'payroll', 'except' => ['show']]);
    Route::get(
        'get-nationalities',
        'PayrollNationalityController@getPayrollNationalities'
    )->name('payroll.get-payroll-nationalities');

    Route::resource('concept-types', 'PayrollConceptTypeController', ['as' => 'payroll', 'except' => ['show']]);


    Route::resource('language-levels', 'PayrollLanguageLevelController', ['as' => 'payroll', 'except' => ['show']]);
    Route::get(
        'get-language-levels',
        'PayrollLanguageLevelController@getPayrollLanguageLevels'
    )->name('payroll.get-payroll-language-levels');

    Route::resource('languages', 'PayrollLanguageController', ['as' => 'payroll', 'except' => ['show']]);
    Route::get('get-languages', 'PayrollLanguageController@getPayrollLanguages')->name('payroll.get-payroll-languages');

    Route::resource('genders', 'PayrollGenderController', ['as' => 'payroll', 'except' => ['show']]);
    Route::get('get-genders', 'PayrollGenderController@getPayrollGenders')->name('payroll.get-payroll-genders');

    Route::resource('socioeconomic-informations', 'PayrollSocioeconomicInformationController', ['as' => 'payroll']);
    Route::get(
        'socioeconomic-informations/show/vue-list',
        'PayrollSocioeconomicInformationController@vueList'
    )->name('payroll.socioeconomic-informations.vue-list');

    Route::resource('professional-informations', 'PayrollProfessionalInformationController', ['as' => 'payroll']);
    Route::get(
        'professional-informations/show/vue-list',
        'PayrollProfessionalInformationController@vueList'
    )->name('payroll.professional-informations.vue-list');

    Route::resource(
        'inactivity-types',
        'PayrollInactivityTypeController',
        ['as' => 'payroll', 'except' => ['show','create','edit']]
    );
    Route::get(
        'get-inactivity-types',
        'PayrollInactivityTypeController@getPayrollInactivityTypes'
    )->name('payroll.get-payroll-inactivity-types');

    Route::resource(
        'contract-types',
        'PayrollContractTypeController',
        ['as' => 'payroll', 'except' => ['show','create','edit']]
    );
    Route::get(
        'get-contract-types',
        'PayrollContractTypeController@getPayrollContractTypes'
    )->name('payroll.get-payroll-contract-types');

    Route::resource(
        'sector-types',
        'PayrollSectorTypeController',
        ['as' => 'payroll', 'except' => ['show','create','edit']]
    );
    Route::get(
        'get-sector-types',
        'PayrollSectorTypeController@getPayrollSectorTypes'
    )->name('payroll.get-payroll-sector-types');

    Route::resource(
        'license-degrees',
        'PayrollLicenseDegreeController',
        ['as' => 'payroll', 'except' => ['show','create','edit']]
    );

    Route::resource(
        'blood-types',
        'PayrollBloodTypeController',
        ['as' => 'payroll', 'except' => ['show','create','edit']]
    );

    Route::resource('employment-informations', 'PayrollEmploymentInformationController', ['as' => 'payroll']);
    Route::get(
        'employment-informations/show/vue-list',
        'PayrollEmploymentInformationController@vueList'
    )->name('payroll.employment-informations.vue-list');



    /**
     * ------------------------------------------------------------
     * Rutas para gestionar los escalafones de nómina
     * ------------------------------------------------------------
     */
    Route::resource('salary-scale', 'PayrollSalaryScaleController', ['except' => ['show','create','edit']]);
    Route::post('get-salary-scales', 'PayrollSalaryScaleController@getSalaryScales');
    Route::get('salary-scales/info/{id}', 'PayrollSalaryScaleController@info');

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar los tabuladores de nómina
     * ------------------------------------------------------------
     */
    Route::resource('salary-tabulators', 'PayrollSalaryTabulatorController', ['except' => ['show','create','edit']]);
    Route::get('salary-tabulators/export/{tabulator}', 'PayrollSalaryTabulatorController@export');
    Route::get('get-salary-tabulators', 'PayrollSalaryTabulatorController@getSalaryTabulators');

    /**
     * ------------------------------------------------------------
     * Rutas para gestionar las asignaciones de nómina
     * ------------------------------------------------------------
     */
    Route::resource('salary-assignments', 'PayrollSalaryAssignmentController', ['except' => ['show','create','edit']]);
    Route::get('salary-assignments/export/{assignment}', 'PayrollSalaryAssignmentController@export');
    Route::resource(
        'salary-assignment-types',
        'PayrollSalaryAssignmentTypeController',
        ['except' => ['show','create','edit']]
    );
    Route::get('get-salary-assignment-types', 'PayrollSalaryAssignmentTypeController@getAssignmentTypes');
});
