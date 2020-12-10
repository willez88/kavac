<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'middleware' => ['web', 'auth', 'verified'],
    'prefix' => 'payroll'
], function () {

    /** Rutas para gestionar la nómina de trabajadores de la institución */
    Route::resource('registers', 'PayrollController', ['as' => 'payroll', 'except' => ['edit','show']]);

    /** Ruta que permite editar la información de un registro de nómina */
    Route::get('registers/edit/{register}', 'PayrollController@edit')->name('payroll.registers.edit');

    /** Ruta que permite visualizar la información de un registro de nómina */
    Route::get('registers/show/{register}', 'PayrollController@show')->name('payroll.registers.show');

    /** Ruta que obtiene la información de un registro de nómina */
    Route::get('registers/vue-info/{register}', 'PayrollController@vueInfo')->name('payroll.registers.vue-info');

    /** Ruta que obtiene un listado de los registros de nómina */
    Route::get('registers/vue-list', 'PayrollController@vueList')->name('payroll.registers.vue-list');

    /** Ruta que actualiza el estado de un registro de nómina para evitar su edición */
    Route::patch('registers/close/{register}', 'PayrollController@close')->name('payroll.registers.close');

    /** Ruta para visualizar la sección de configuración del módulo */
    Route::get('settings', 'PayrollSettingController@index')->name('payroll.settings.index');

    /** Ruta para guardar los cambios en la sección de configuración del módulo */
    Route::post('settings', 'PayrollSettingController@store')->name('payroll.settings.store');

    /** Rutas para gestionar el tipo de personal */
    Route::resource(
        'staff-types',
        'PayrollStaffTypeController',
        ['as' => 'payroll', 'except' => ['create','edit','show']]
    );

    /** Ruta que obtiene un arreglo con los tipos de personal registrados */
    Route::get(
        'get-staff-types',
        'PayrollStaffTypeController@getPayrollStaffTypes'
    )->name('payroll.get-payroll-staff-types');

    /** Rutas para gestionar el tipo de cargo */
    Route::resource(
        'position-types',
        'PayrollPositionTypeController',
        ['as' => 'payroll', 'except' => ['create','edit','show']]
    );

    /** Ruta que obtiene un arreglo con los tipos de cargo registrados */
    Route::get(
        'get-position-types',
        'PayrollPositionTypeController@getPayrollPositionTypes'
    )->name('payroll.get-payroll-position-types');

    /** Rutas para gestionar los cargos */
    Route::resource(
        'positions',
        'PayrollPositionController',
        ['as' => 'payroll', 'except' => ['create','edit','show']]
    );

    /** Ruta que obtiene un arreglo con los cargos registrados */
    Route::get(
        'get-positions',
        'PayrollPositionController@getPayrollPositions'
    )->name('payroll.get-payroll-positions');

    /** Rutas para gestionar la clasificación del personal */
    Route::resource(
        'staff-classifications',
        'PayrollStaffClassificationController',
        ['as' => 'payroll', 'except' => ['create','edit','show']]
    );

    /** Ruta que obtiene un arreglo con las clasificaciones del personal registrados */
    Route::get(
        'get-staff-classifications',
        'PayrollStaffClassificationController@getPayrollStaffClassifications'
    )->name('payroll.get-payroll-staff-classifications');

    /** Rutas para gestionar el registro del personal */
    Route::resource('staffs', 'PayrollStaffController', ['as' => 'payroll']);

    /** Ruta que obtiene un listado del peronal activo */
    Route::get('staffs/show/vue-list', 'PayrollStaffController@vueList')->name('payroll.staffs.vue-list');

    /** Ruta que obtiene un arreglo con los registros del personal registrados */
    Route::get('get-staffs', 'PayrollStaffController@getPayrollStaffs')->name('payroll.get-payroll-staffs');

    /** Rutas para gestionar los grados de instrucción */
    Route::resource(
        'instruction-degrees',
        'PayrollInstructionDegreeController',
        ['as' => 'payroll', 'except' => ['show']]
    );

    /** Ruta que obtiene un arreglo con los grados de instrucción registrados */
    Route::get(
        'get-instruction-degrees',
        'PayrollInstructionDegreeController@getPayrollInstructionDegrees'
    )->name('payroll.get-payroll-instruction-degrees');

    /** Rutas para gestionar los tipos de estudios */
    Route::resource(
        'study-types',
        'PayrollStudyTypeController',
        ['as' => 'payroll', 'except' => ['create','edit','show']]
    );

    /** Ruta que obtiene un arreglo con los tipos de estudios registrados */
    Route::get(
        'get-study-types',
        'PayrollStudyTypeController@getPayrollStudyTypes'
    )->name('payroll.get-payroll-study-types');

    /** Rutas para gestionar las nacionalidades */
    Route::resource(
        'nationalities',
        'PayrollNationalityController',
        ['as' => 'payroll', 'except' => ['show']]
    );

    /** Ruta que obtiene un arreglo con las nacionalidades registradas */
    Route::get(
        'get-nationalities',
        'PayrollNationalityController@getPayrollNationalities'
    )->name('payroll.get-payroll-nationalities');

    /** Rutas para gestionar los conceptos */
    Route::resource(
        'concepts',
        'PayrollConceptController',
        ['as' => 'payroll', 'except' => ['show','create','edit']]
    );

    /** Ruta que obtiene un arreglo con los conceptos registrados */
    Route::get(
        'get-concepts',
        'PayrollConceptController@getPayrollConcepts'
    )->name('payroll.get-payroll-concepts');

    /** Ruta que obtiene un arreglo con las opciones a asignar un concepto */
    Route::get(
        'get-concept-assign-to',
        'PayrollConceptController@getPayrollConceptAssignTo'
    )->name('payroll.get-payroll-concept-assign-to');

    /** Ruta que obtiene un arreglo con las opciones a asignar un concepto, de acuerdo al parámetro seleccionado */
    Route::get(
        'get-concept-assign-options/{code}',
        'PayrollConceptController@getPayrollConceptAssignOptions'
    )->name('payroll.get-payroll-concept-assign-options');

    /** Rutas para gestionar los tipos de concepto */
    Route::resource(
        'concept-types',
        'PayrollConceptTypeController',
        ['as' => 'payroll', 'except' => ['show','create','edit']]
    );

    /** Ruta que obtiene un arreglo con los tipos de concepto registrados */
    Route::get(
        'get-concept-types',
        'PayrollConceptTypeController@getPayrollConceptTypes'
    )->name('payroll.get-payroll-concept-types');

    /** Rutas para gestionar los tipos de pago */
    Route::resource(
        'payment-types',
        'PayrollPaymentTypeController',
        ['as' => 'payroll', 'except' => ['show','create','edit']]
    );

    /** Ruta que obtiene un arreglo con los tipos de pago registrados */
    Route::get(
        'get-payment-types',
        'PayrollPaymentTypeController@getPayrollPaymentTypes'
    )->name('payroll.get-payroll-payment-types');

    /** Ruta que obtiene un arreglo con los períodos de pago registrados, de acuerdo al tipo de pago seleccionado */
    Route::get(
        'get-payment-periods/{payment_type}',
        'PayrollPaymentTypeController@getPayrollPaymentPeriods'
    )->name('payroll.get-payroll-payment-periods');

    /** Ruta que obtiene la información de un registro de política vacacional según el trabajador */
    Route::get(
        'get-vacation-policy',
        'PayrollVacationPolicyController@getVacationPolicy'
    );

    /** Rutas para gestionar las políticas vacacionales registradas */
    Route::resource(
        'vacation-policies',
        'PayrollVacationPolicyController',
        ['as' => 'payroll', 'except' => ['create','edit']]
    );

    /** Rutas para gestionar los niveles de idioma */
    Route::resource(
        'language-levels',
        'PayrollLanguageLevelController',
        ['as' => 'payroll', 'except' => ['show']]
    );

    /** Ruta que obtiene un arreglo con los niveles de idioma registrados */
    Route::get(
        'get-language-levels',
        'PayrollLanguageLevelController@getPayrollLanguageLevels'
    )->name('payroll.get-payroll-language-levels');

    /** Rutas para gestionar los idiomas */
    Route::resource('languages', 'PayrollLanguageController', ['as' => 'payroll', 'except' => ['show']]);

    /** Ruta que obtiene un arreglo con los idiomas registrados */
    Route::get('get-languages', 'PayrollLanguageController@getPayrollLanguages')->name('payroll.get-payroll-languages');

    /** Rutas para gestionar los géneros */
    Route::resource('genders', 'PayrollGenderController', ['as' => 'payroll', 'except' => ['show']]);

    /** Ruta que obtiene un arreglo con los géneros registrados */
    Route::get('get-genders', 'PayrollGenderController@getPayrollGenders')->name('payroll.get-payroll-genders');

    /** Rutas para gestionar los datos socioeconómicos del personal */
    Route::resource('socioeconomics', 'PayrollSocioeconomicController', ['as' => 'payroll']);

    /** Ruta que obtiene un listado de los datos socioeconómicos del personal */
    Route::get(
        'socioeconomics/show/vue-list',
        'PayrollSocioeconomicController@vueList'
    )->name('payroll.socioeconomics.vue-list');

    /** Rutas para gestionar los datos profesionales del personal */
    Route::resource('professionals', 'PayrollProfessionalController', ['as' => 'payroll']);

    /** Ruta que obtiene un listado de los datos profesionales del personal */
    Route::get(
        'professionals/show/vue-list',
        'PayrollProfessionalController@vueList'
    )->name('payroll.professionals.vue-list');

    /** Ruta que obtiene un arreglo con las profesiones registrados */
    Route::get(
        'get-json-professions',
        'PayrollProfessionalController@getJsonProfessions'
    )->name('payroll.get-json-professions');

    /** Rutas para gestionar los tipos de inactividad */
    Route::resource(
        'inactivity-types',
        'PayrollInactivityTypeController',
        ['as' => 'payroll', 'except' => ['show','create','edit']]
    );

    /** Ruta que obtiene un arreglo con los tipos de inactividad registrados */
    Route::get(
        'get-inactivity-types',
        'PayrollInactivityTypeController@getPayrollInactivityTypes'
    )->name('payroll.get-payroll-inactivity-types');

    /** Rutas para gestionar los tipos de contrato */
    Route::resource(
        'contract-types',
        'PayrollContractTypeController',
        ['as' => 'payroll', 'except' => ['show','create','edit']]
    );

    /** Ruta que obtiene un arreglo con los tipos de contrato registrados */
    Route::get(
        'get-contract-types',
        'PayrollContractTypeController@getPayrollContractTypes'
    )->name('payroll.get-payroll-contract-types');

    /** Rutas para gestionar los tipos de sector */
    Route::resource(
        'sector-types',
        'PayrollSectorTypeController',
        ['as' => 'payroll', 'except' => ['show','create','edit']]
    );

    /** Ruta que obtiene un arreglo con los tipos de sector registrados */
    Route::get(
        'get-sector-types',
        'PayrollSectorTypeController@getPayrollSectorTypes'
    )->name('payroll.get-payroll-sector-types');

    /** Rutas para gestionar los grados de licencia de conducir */
    Route::resource(
        'license-degrees',
        'PayrollLicenseDegreeController',
        ['as' => 'payroll', 'except' => ['show','create','edit']]
    );

    /** Ruta que obtiene un arreglo con los grados de licencia de conducir registrados */
    Route::get(
        'get-license-degrees',
        'PayrollLicenseDegreeController@getPayrollLicenseDegrees'
    )->name('payroll.get-payroll-license-degrees');

    /** Rutas para gestionar los tipos de sangre */
    Route::resource(
        'blood-types',
        'PayrollBloodTypeController',
        ['as' => 'payroll', 'except' => ['show','create','edit']]
    );

    /** Ruta que obtiene un arreglo con los tipos de sangre registrados */
    Route::get(
        'get-blood-types',
        'PayrollBloodTypeController@getPayrollBloodTypes'
    )->name('payroll.get-payroll-blood-types');

    /** Rutas para gestionar los datos laborales del personal */
    Route::resource('employment-informations', 'PayrollEmploymentInformationController', ['as' => 'payroll']);

    /** Ruta que obtiene un listado de los datos laborales del personal */
    Route::get(
        'employment-informations/show/vue-list',
        'PayrollEmploymentInformationController@vueList'
    )->name('payroll.employment-informations.vue-list');



    /** Rutas para gestionar los parámetros de nómina */
    Route::resource('parameters', 'PayrollParameterController', ['except' => ['show','create','edit']]);

    /** Ruta que obtiene un arreglo con los parámetros de nómina registrados */
    Route::get('get-parameters', 'PayrollParameterController@getPayrollParameters');

    /** Ruta que obtiene un arreglo con parámetros de nómina registrados asociados a un concepto */
    Route::post('get-parameters', 'PayrollParameterController@getPayrollParameters');

    /** Ruta que obtiene un arreglo con los parámetros asociados al expediente del trabajador registrados */
    Route::get('get-parameter-options/{code}', 'PayrollParameterController@getPayrollParameterOptions');

    /** Ruta que obtiene un arreglo con los tipos de parámetros de nómina registrados */
    Route::get('get-parameter-types', 'PayrollParameterController@getPayrollParameterTypes');


    /** Rutas para gestionar los escalafones de nómina */
    Route::resource('salary-scales', 'PayrollSalaryScaleController', ['except' => ['show','create','edit']]);

    /** Ruta que obtiene un arreglo con los escalafones de nómina registrados */
    Route::post('get-salary-scales', 'PayrollSalaryScaleController@getSalaryScales');

    /** Ruta que obtiene la información de un escalafón de nómina registrado */
    Route::get('salary-scales/info/{id}', 'PayrollSalaryScaleController@info');

    /** Rutas para gestionar los tabuladores de nómina */
    Route::resource('salary-tabulators', 'PayrollSalaryTabulatorController', ['except' => ['show','create','edit']]);

    /** Ruta que obtiene la información de un registro de nómina */
    Route::get(
        'salary-tabulators/show/{tabulator}',
        'PayrollSalaryTabulatorController@show'
    )->name('payroll.salary-tabulators.show');

    /** Ruta que permite exportar la información de los tabuladores salariales registrados */
    Route::get('salary-tabulators/export/{tabulator}', 'PayrollSalaryTabulatorController@export');

    /** Ruta que obtiene un arreglo con los tabuladores salariales registrados */
    Route::get('get-salary-tabulators', 'PayrollSalaryTabulatorController@getSalaryTabulators');

    /** Ruta que obtiene un arreglo con las agrupaciones de los tabuladores salariales registrados */
    Route::get('get-salary-tabulators-groups', 'PayrollParameterController@getSalaryTabulatorsGroups');

    /** Ruta que obtiene un arreglo con los registros asociados al expediente del trabajador registrados */
    Route::get('get-associated-records', 'PayrollParameterController@getAssociatedRecords');

    /** Ruta que obtiene un arreglo con los registros asociados a las vacaciones registrados */
    Route::get('get-vacation-associated-records', 'PayrollParameterController@getVacationAssociatedRecords');

    /** Rutas para gestionar los ajustes en las tablas salariales */
    Route::resource(
        'salary-adjustments',
        'PayrollSalaryAdjustmentController',
        ['as' => 'payroll'],
        ['only' => ['create', 'store']]
    );

    /** Rutas para gestionar las solicitudes de vacaciones */
    Route::resource(
        'vacation-requests',
        'PayrollVacationRequestController',
        ['as' => 'payroll', 'except' => ['edit', 'show']]
    );

    /** Ruta que obtiene un listado de las solicitudes de vacaciones */
    Route::get(
        'vacation-requests/vue-list',
        'PayrollVacationRequestController@vueList'
    )->name('payroll.vacation-requests.vue-list');

    /** Ruta que obtiene un listado de las solicitudes de vacaciones pendientes */
    Route::get(
        'vacation-requests/vue-pending-list',
        'PayrollVacationRequestController@vuePendingList'
    )->name('payroll.vacation-requests.vue-pending-list');

    /** Ruta que permite actualizar una solicitud de vacaciones*/
    Route::patch(
        'vacation-requests/review/{request}',
        'PayrollVacationRequestController@review')
    ->name('payroll.request.review');

    /** Ruta que permite editar la información de un registro de solicitud de vacaciones */
    Route::get(
        'vacation-requests/edit/{vacation_request}',
        'PayrollVacationRequestController@edit'
    )->name('payroll.vacation-requests.edit');

    /** Ruta que obtiene la información de un registro de solicitud de vacaciones */
    Route::get(
        'vacation-requests/show/{vacation_request}',
        'PayrollVacationRequestController@show'
    )->name('payroll.vacation-requests.show');

    /** Ruta que obtiene un listado de las solicitudes de vacaciones de un trabajador */
    Route::get(
        'get-vacation-requests/{staff_id}',
        'PayrollVacationRequestController@getVacationRequests'
    );

    /**
     * ------------------------------------------------------------
     * Grupo de rutas para gestionar la generación de reportes en el módulo de talento humano
     * ------------------------------------------------------------
     */
    Route::group([
        'middleware' => ['web', 'auth', 'verified'],
        'prefix' => 'reports'
    ], function () {
        Route::get('show/{filename}', 'PayrollReportController@show')
        ->name('payroll.reports.show');
        
        Route::get('vacation-enjoyment-summaries', 'PayrollReportController@vacationEnjoymentSummaries')
        ->name('payroll.reports.vacation-enjoyment-summaries');
        Route::post('vacation-enjoyment-summaries/create', 'PayrollReportController@create')
        ->name('payroll.reports.vacation-enjoyment-summaries.create');

        Route::get('vacation-status', 'PayrollReportController@vacationStatus')
        ->name('payroll.reports.vacation-status');
        Route::post('vacation-status/create', 'PayrollReportController@create')
        ->name('payroll.reports.vacation-status.create');

        Route::get('vacation-bonus-calculations', 'PayrollReportController@vacationBonusCalculations')
        ->name('payroll.reports.vacation-bonus-calculations');
        Route::post('vacation-bonus-calculations/create', 'PayrollReportController@create')
        ->name('payroll.reports.vacation-bonus-calculations.create');

        Route::post('vue-list', 'PayrollReportController@vueList')
        ->name('payroll.reports.vue-list');
    });
});
