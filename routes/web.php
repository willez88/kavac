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

/**
 * -----------------------------------------------------------------------
 * Ruta para la gestión de acceso a la aplicación
 * -----------------------------------------------------------------------
 *
 * Condiciona el acceso a la aplicación y evalúa si el usuario esta
 * autenticado en el sistema, si lo está, redirecciona a la página principal
 * de lo contrario muestra la interfaz de autenticación
 */
Route::get('/', 'DashboardController@index')->middleware('verified')->name('index');
Route::post('unlockscreen', 'Auth\UserController@unlockScreen')->name('unlockscreen');

/**
 * -----------------------------------------------------------------------
 * Rutas para la gestión de acceso al sistema
 * -----------------------------------------------------------------------
 *
 * Gestiona las rutas de:
 * - login (GET|POST)
 * - logout
 * - password/email
 * - password/reset
 * - password/reset/{token}
 */
Auth::routes(['verify' => true]);

/**
 * -----------------------------------------------------------------------
 * Ruta para recargar la imagen del captcha
 * -----------------------------------------------------------------------
 *
 * Gestiona el proceso para generar una nueva imagen de captcha a petición del usuario
 */
Route::get('/refresh-captcha', 'Auth\LoginController@refreshCaptcha');

/**
 * -----------------------------------------------------------------------
 * Ruta para generar logs del sistema
 * -----------------------------------------------------------------------
 *
 * Gestiona los logs de la aplicación
 */
Route::post('/logs/front-end', 'Admin\LogController@frontEnd')->name('logs.front-end');


/**
 * -----------------------------------------------------------------------
 * Grupo de rutas para la gestión general de registros
 * -----------------------------------------------------------------------
 *
 * Permite gestionar los distintos modelos de uso común en la aplicación y
 * el acceso a los distintos discos establecidos en la configuración de
 * config/filesystems.php
 */
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/home', 'DashboardController@index')->middleware('verified');
    /**
     * -----------------------------------------------------------------------
     * Ruta para mostrar imágenes almacenadas
     * -----------------------------------------------------------------------
     *
     * Permite acceder y mostrar las imágenes almacenadas
     */
    Route::get('storage/pictures/{image}', function ($image) {
        $path = storage_path('pictures/' . $image);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

    /**
     * -----------------------------------------------------------------------
     * Ruta para mostrar documentos almacenados
     * -----------------------------------------------------------------------
     *
     * Permite acceder y mostrar los documentos almacenados
     */
    Route::get('storage/documents/{document}', function ($document) {
        $path = storage_path('documents/' . $document);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

    /**
     * -----------------------------------------------------------------------
     * Ruta para gestión de parámetros
     * -----------------------------------------------------------------------
     *
     * Ruta para la configuración de parámetros generales de la aplicación y
     * de los módulos
     */
    Route::post('parameters', 'ParameterController@store')->name('parameters.store');

    /**
     * -----------------------------------------------------------------------
     * Rutas para gestión de estatus de documentos
     * -----------------------------------------------------------------------
     *
     * Rutas de recursos para la gestión de estatus de documentos.
     */
    Route::resource('document-status', 'DocumentStatusController', ['except' => ['create', 'show', 'edit']]);

    /**
     * -----------------------------------------------------------------------
     * Rutas para gestión de documentos requeridos
     * -----------------------------------------------------------------------
     *
     * Rutas para la gestión de documentos requeridos.
     */
    Route::get(
        'required-documents/{model}/{module?}',
        'RequiredDocumentController@index'
    )->name('required.documents.index');
    Route::post(
        'required-documents/{model}/{module?}',
        'RequiredDocumentController@store'
    )->name('required.documents.store');
    Route::patch(
        'required-documents/{model}/{module?}/{requiredDocument}',
        'RequiredDocumentController@update'
    )->name('required.documents.update');
    Route::delete(
        'required-documents/{model}/{module?}/{requiredDocument}',
        'RequiredDocumentController@destroy'
    )->name('required.documents.destroy');

    /** Rutas para la gestión de estados civiles */
    Route::resource('marital-status', 'MaritalStatusController', ['except' => ['create', 'show', 'edit']]);
    Route::get(
        '/get-marital-status/{id?}',
        'MaritalStatusController@getMaritalStatus'
    )->name('get-marital-status');

    /** Rutas para la gestión de profesiones */
    Route::resource('professions', 'ProfessionController', ['except' => ['create', 'show', 'edit']]);
    Route::get(
        '/get-professions/{id?}',
        'ProfessionController@getProfessions'
    )->name('get-professions');

    /** Rutas para la gestión de tipos de instituciones */
    Route::resource('institution-types', 'InstitutionTypeController', ['except' => ['create', 'show', 'edit']]);

    /** Rutas para la gestión de sectores de instituciones */
    Route::resource('institution-sectors', 'InstitutionSectorController', ['except' => ['create', 'show', 'edit']]);

    /** Rutas para la gestión de Países */
    Route::resource('countries', 'CountryController', ['except' => ['create', 'show', 'edit']]);

    /** Rutas para la gestión de Estados de Países */
    Route::resource('estates', 'EstateController', ['except' => ['create', 'show', 'edit']]);

    /** Rutas para la gestión de Municipios de Estados */
    Route::resource('municipalities', 'MunicipalityController', ['except' => ['create', 'show', 'edit']]);

    /** Rutas para la gestión de Ciudades de Estados */
    Route::resource('cities', 'CityController', ['except' => ['create', 'show', 'edit']]);

    /** Rutas para la gestión de Parroquias de Municipios */
    Route::resource('parishes', 'ParishController', ['except' => ['create', 'show', 'edit']]);

    /** Rutas para la gestión de Impuestos */
    Route::resource('taxes', 'TaxController', ['except' => ['create', 'show', 'edit']]);
    Route::get('get-taxes', 'TaxController@getAll')->name('taxes.get-all');

    /** Rutas para la gestión de Unidades Tributarias */
    Route::resource('tax-units', 'TaxUnitController', ['except' => ['create', 'show', 'edit']]);

    /** Rutas para la gestión de deducciones */
    Route::resource('deductions', 'DeductionController', ['except' => ['create', 'show', 'edit']]);

    /** Rutas para la gestión de unidades, departamentos o dependencias */
    Route::resource('departments', 'DepartmentController', ['except' => ['create', 'show', 'edit']]);

    /** Rutas para la gestión de monedas y tipos de cambio */
    Route::resource('currencies', 'CurrencyController', ['except' => ['create', 'show', 'edit']]);
    Route::get(
        'currencies/info/{currency_id}',
        'CurrencyController@getCurrencyInfo'
    )->name('currency.info');

    /** Ruta para obtener datos de selecs dependientes dinámicamente */
    Route::get(
        'get-select-data/{parent_name}/{parent_id}/{model}/{module_name?}/{fk?}',
        'CommonController@getSelectData'
    )->name('get-select-data');

    /** Ruta para obtener datos de los departamentos */
    Route::get(
        '/get-departments/{institution_id}',
        'DepartmentController@getDepartments'
    )->name('get-departments');

    /** Ruta para obtener datos de instituciones */
    Route::get(
        '/get-institutions/{institution_id?}',
        'InstitutionController@getInstitutions'
    )->name('get-institutions');
    Route::get(
        '/get-execution-year/{institution_id?}/{year?}',
        'InstitutionController@getExecutionYear'
    )->name('get-execution-year');

    /** Ruta para obtener datos de monedas */
    Route::get(
        '/get-currencies/{currency_id?}',
        'CurrencyController@getCurrencies'
    )->name('get-currencies');

    /** Ruta para la gestión de imágenes */
    Route::resource('upload-image', 'ImageController', [
        'except' => ['index', 'create', 'show', 'edit', 'update']
    ]);
    Route::get('get-image/{image}', 'ImageController@getImage')->name('get-image');

    /** Ruta para la gestión de documentos */
    Route::resource('upload-document', 'DocumentController', [
        'except' => ['index', 'create', 'show', 'edit', 'update']
    ]);
    Route::get('get-document/{document}', 'DocumentController@getDocument')->name('get-document');

    /** Rutas para la gestión de perfiles */
    Route::resource('profiles', 'ProfileController', [
        'except' => ['index', 'create', 'show', 'edit', 'update', 'destroy']
    ]);

    /** Rutas para la gestión de años fiscales */
    Route::resource('fiscal-years', 'FiscalYearController', ['except' => ['show']]);
    Route::get('fiscal-years/opened/list', 'FiscalYearController@getOpened')->name('opened.fiscal-years');

    /** Rutas para la gestión de unidades de medida */
    Route::resource('measurement-units', 'MeasurementUnitController', ['except' => ['create', 'show', 'edit']]);

    /** Rutas para la gestión de tipos de cambio */
    Route::resource('exchange-rates', 'ExchangeRateController', ['except' => ['create', 'show', 'edit']]);

    /** Rutas para gestionar notificaciones del sistema */
    //Route::post('system/notify/send', 'SystemNotificationController@send');

    /** Ruta para acceder a la configuración del usuario autenticado */
    Route::get('my-settings', 'Auth\UserController@userSettings')->name('my.settings');
    Route::post('my-settings/general', 'Auth\UserController@setUserSettings')->name('set.my.settings');
    Route::post('my-settings/notifications', 'Auth\UserController@setMyNotifications')->name('set.my.notifications');

    /** Rutas que permiten gestionar datos para el bloqueo de pantalla por inactividad */
    Route::get('get-lockscreen-data', 'Auth\UserController@getLockScreenData')->name('get-lockscreen-data');
    Route::post('set-lockscreen-data', 'Auth\UserController@setLockScreenData')->name('set-lockscreen-data');

    /** Rutas para gestionar los datos de los receptores de procesos dentro de la aplicación */
    Route::resource('receivers', 'ReceiverController');
});

/**
 * -----------------------------------------------------------------------
 * Grupo de rutas establecidas en el namespace Auth
 * -----------------------------------------------------------------------
 *
 * Gestiona los controladores que se encuentran en el namespace Auth y que
 * requieren de que el usuario se encuentre autenticado en el sistema
 */
Route::group(['middleware' => ['auth', 'verified'], 'namespace' => 'Auth'], function () {
    /** Ruta de recursos para la gestión de usuarios */
    Route::resource('users', 'UserController');
    Route::get('user-info/{user}', 'UserController@info')->name('user-info');
    Route::get('user-unlock/{user}', 'UserController@unlock')->name('user-unlock');
    Route::get('users-all', 'UserController@getAll')->name('users-all');
});

/**
 * -----------------------------------------------------------------------
 * Grupo de rutas para la gestión de servicios del sistema
 * -----------------------------------------------------------------------
 *
 * Gestiona diferentes datos dentro de la aplicación y retorna los mismos
 * en formato json, estos a su vez requieren de que el usuario se encuentre
 * autenticado en el sistema para poder hacer uso de ellos
 */
Route::group(['middleware' => ['auth', 'verified'], 'namespace' => 'Services'], function () {
    /** Obtiene los países registrados */
    Route::get('get-countries', 'LocatesController@getCountries');
    /** Obtiene los estados de un país */
    Route::get('get-estates/{country_id}', 'LocatesController@getEstates');
    /** Obtiene los municipios de un estado */
    Route::get('get-municipalities/{estate_id}', 'LocatesController@getMunicipalities');
    /** Obtiene las ciudades de un estado */
    Route::get('get-cities/{estate_id}', 'LocatesController@getCities');
    /** Obtiene las parroquias de un municipio */
    Route::get('get-parishes/{municipality_id}', 'LocatesController@getParishes');

    /** Grupo de rutas para la gestión de notificaciones */
    Route::group(['prefix' => 'notifications'], function () {
        /** Obtiene las notificaciones no leídas */
        Route::get('unreaded', 'NotificationsController@getUnreaded');
        /** Obtiene las notificaciones leídas */
        Route::get('readed', 'NotificationsController@getReaded');
        /** Obtiene todas las notificaciones del usuario */
        Route::get('all', 'NotificationsController@getAll');
        /** Mustra el listado de notificaciones */
        Route::get('list', 'NotificationsController@show')->name('notifications.list');
    });
});

/**
 * -----------------------------------------------------------------------
 * Grupo de rutas de acceso exclusivo del usuario desarrollador
 * -----------------------------------------------------------------------
 *
 * Gestiona las rutas que solo pueden accederse si el usuario autenticado
 * es un desarrollador del sistema
 */
Route::group(['middleware' => ['auth', 'verified', 'role:dev'], 'namespace' => 'Dev', 'prefix' => 'dev'], function () {
    /** Muestra un listado de íconos a utilizar en el sistema */
    Route::get('show/{el}', 'DevelopmentController@getElement')->name('dev.show.element');
    /** Rutas para el visor de logs */
    Route::group(['prefix' => 'log-viewer'], function () {
        Route::get('/', 'LogViewerController@index')->name('log-viewer::details');
    });
});

/** Ruta pública para acceder a los documentos almacenados por la aplicación */
Route::get('public/documents/{document}', function ($document) {
    $path = storage_path('public_documents/' . $document);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});



Route::post('report', 'ReportController@create');
Route::post('report/sign', 'ReportController@sign');
Route::get('documents/verify/{document}', 'ReportController@verify');
