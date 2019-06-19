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
    Route::get('staffs/show/list', 'PayrollStaffController@list')->name('payroll.staffs.list');

    Route::resource('instruction-degrees', 'PayrollInstructionDegreeController', ['as' => 'payroll', 'except' => ['show']]);
    Route::get('instruction-degrees/list', 'PayrollInstructionDegreeController@list')->name('payroll.instruction-degrees.list');

    Route::resource('study-types', 'PayrollStudyTypeController', ['as' => 'payroll', 'except' => ['show']]);
    Route::get('study-types/list', 'PayrollStudyTypeController@list')->name('payroll.study-types.list');

    Route::resource('nationalities', 'PayrollNationalityController', ['as' => 'payroll', 'except' => ['show']]);
    Route::resource('concept-types', 'PayrollConceptTypeController', ['as' => 'payroll', 'except' => ['show']]);


    Route::resource('language-levels', 'PayrollLanguageLevelController', ['as' => 'payroll', 'except' => ['show']]);
    Route::get('language-levels/list', 'PayrollLanguageLevelController@list')->name('payroll.language-levels.list');

    Route::resource('languages', 'PayrollLanguageController', ['as' => 'payroll', 'except' => ['show']]);
    Route::get('languages/list', 'PayrollLanguageController@list')->name('payroll.languages.list');

    Route::resource('genders', 'PayrollGenderController', ['as' => 'payroll', 'except' => ['show']]);

    Route::resource('socioeconomic-informations', 'PayrollSocioeconomicInformationController', ['as' => 'payroll']);
    Route::get('socioeconomic-informations/show/vue-list', 'PayrollSocioeconomicInformationController@vueList')->name('payroll.socioeconomic-informations.vue-list');
    Route::get('socioeconomic-informations/info/{id}', 'PayrollSocioeconomicInformationController@info')->name('payroll.socioeconomic-informations.info');
    Route::get('socioeconomic-informations/show/marital-status-list', 'PayrollSocioeconomicInformationController@maritalStatusList')->name('payroll.socioeconomic-informations.marital-status-list');

    Route::resource('professional-informations', 'PayrollProfessionalInformationController', ['as' => 'payroll']);
    Route::get('professional-informations/info/{id}', 'PayrollProfessionalInformationController@info')->name('payroll.professional-informations.info');
    Route::get('professional-informations/show/professions-list', 'PayrollProfessionalInformationController@professionsList')->name('payroll.professional-informations.professions-list');
    Route::get('professional-informations/show/vue-list', 'PayrollProfessionalInformationController@vueList')->name('payroll.professional-informations.vue-list');
});
