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
Route::get('/', function () {
    if (Auth::check()) {
		/** Si el usuario esta autenticado redirecciona a la página del panel de control */
        return view('dashboard.index');
    }
    else {
    	/** Si el usuario no está autenticado muestra la página de acceso */
        return view('auth.login');
    }
})->name('index');

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
Auth::routes();

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
 * Grupo de rutas para la gestión general de registros
 * -----------------------------------------------------------------------
 *
 * Permite gestionar los distintos modelos de uso común en la aplicación y 
 * el acceso a los distintos discos establecidos en la configuración de 
 * config/filesystems.php
 */
Route::group(['middleware' => 'auth'], function() {
	/** Ruta para acceder a las imágenes almacenadas por la aplicación */
    Route::get('storage/pictures/{image}', function($image) {
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
    /** Ruta para acceder a los documentos almacenados por la aplicación */
    Route::get('storage/documents/{document}', function($document) {
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

    /** Rutas para la gestión de estatus de documentos */
    Route::resource('document-status', 'DocumentStatusController', ['except' => ['show']]);

    /** Rutas para la gestión de estados civiles */
    Route::resource('marital-status', 'MaritalStatusController', ['except' => ['show']]);

    /** Rutas para la gestión de profesiones */
    Route::resource('professions', 'ProfessionController', ['except' => ['show']]);

    /** Rutas para la gestión de tipos de instituciones */
    Route::resource('institution-types', 'InstitutionTypeController', ['except' => ['show']]);

    /** Rutas para la gestión de sectores de instituciones */
    Route::resource('institution-sectors', 'InstitutionSectorController', ['except' => ['show']]);

    /** Rutas para la gestión de Países */
    Route::resource('countries', 'CountryController', ['except' => ['show']]);

    /** Rutas para la gestión de Estados de Países */
    Route::resource('estates', 'EstateController', ['except' => ['show']]);

    /** Rutas para la gestión de Municipios de Estados */
    Route::resource('municipalities', 'MunicipalityController', ['except' => ['show']]);

    /** Rutas para la gestión de Ciudades de Estados */
    Route::resource('cities', 'CityController', ['except' => ['show']]);

    /** Rutas para la gestión de Parroquias de Municipios */
    Route::resource('parishes', 'ParishController', ['except' => ['show']]);

    /** Rutas para la gestión de Impuestos */
    Route::resource('taxes', 'TaxController');
});

/**
 * -----------------------------------------------------------------------
 * Grupo de rutas establecidas en el namespace Auth
 * -----------------------------------------------------------------------
 *
 * Gestiona los controladores que se encuentran en el namespace Auth y que 
 * requieren de que el usuario se encuentre autenticado en el sistema
 */
Route::group(['middleware' => 'auth', 'namespace' => 'Auth'], function() {
    /** Ruta de recursos para la gestión de usuarios */
    Route::resource('users', 'UserController');
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
Route::group(['middleware' => 'auth', 'namespace' => 'Services'], function() {
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
});

/**
 * -----------------------------------------------------------------------
 * Grupo de rutas de acceso exclusivo del usuario administrador
 * -----------------------------------------------------------------------
 *
 * Gestiona las rutas que solo pueden accederse si el usuario autenticado 
 * es administrador del sistema
 */
Route::group(['middleware' => ['auth', 'role:admin'], 'namespace' => 'Admin'], function() {
    /** Ruta para la configuración de la aplicación */
    Route::resource('settings', 'SettingController', [
        'except' => ['create', 'edit', 'show', 'update', 'destroy']
    ]);
    /** Ruta para la gestión de información sobre la(s) institución(es) */
    Route::resource('institution', 'InstitutionController', [
        'except', 'index', 'create', 'show'
    ]);

    /** Rutas para gestionar respaldos de la aplicación */
    Route::get('backup', 'BackupController@index')->name('backup.index');
    Route::get('backup/create', 'BackupController@create')->name('backup.create');
    Route::get('backup/download/{file_name}', 'BackupController@download')
         ->name('backup.download');
    Route::get('backup/delete/{file_name}', 'BackupController@delete')->name('backup.delete');
});