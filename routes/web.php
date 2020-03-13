<?php
use App\User;
use App\Notifications\SystemNotification;

Route::get('test-notify', function () {
    $user = User::find(1);
    $user->notify(new SystemNotification('prueba', 'prueba de notificación'));
    echo "Notificación enviada";
});
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
    Route::resource('document-status', 'DocumentStatusController', ['except' => ['show']]);

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
    Route::resource('marital-status', 'MaritalStatusController', ['except' => ['show']]);
    Route::get(
        '/get-marital-status/{id?}',
        'MaritalStatusController@getMaritalStatus'
    )->name('get-marital-status');

    /** Rutas para la gestión de profesiones */
    Route::resource('professions', 'ProfessionController', ['except' => ['show']]);
    Route::get(
        '/get-professions/{id?}',
        'ProfessionController@getProfessions'
    )->name('get-professions');

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

    /** Rutas para la gestión de Unidades Tributarias */
    Route::resource('tax-units', 'TaxUnitController');

    /** Rutas para la gestión de deducciones */
    Route::resource('deductions', 'DeductionController');

    /** Rutas para la gestión de unidades, departamentos o dependencias */
    Route::resource('departments', 'DepartmentController');

    /** Rutas para la gestión de monedas y tipos de cambio */
    Route::resource('currencies', 'CurrencyController');
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

    /** Rutas para la gestión de perfiles */
    Route::resource('profiles', 'ProfileController');

    /** Rutas para la gestión de años fiscales */
    Route::resource('fiscal-years', 'FiscalYearController', ['except' => ['show']]);

    /** Rutas para la gestión de unidades de medida */
    Route::resource('measurement-units', 'MeasurementUnitController', ['except' => ['show']]);

    /** Rutas para la gestión de tipos de cambio */
    Route::resource('exchange-rates', 'ExchangeRateController', ['except' => ['show']]);

    /** Rutas para gestionar notificaciones del sistema */
    //Route::post('system/notify/send', 'SystemNotificationController@send');
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

/**
 * -----------------------------------------------------------------------
 * Grupo de rutas de acceso exclusivo del usuario administrador
 * -----------------------------------------------------------------------
 *
 * Gestiona las rutas que solo pueden accederse si el usuario autenticado
 * es administrador del sistema
 */
Route::group(['middleware' => ['auth', 'verified', 'role:admin']], function () {
    Route::get('restore/{model}/{id}', 'DashboardController@restore');

    /**
     * ------------------------------------------------------------------
     * Grupo de rutas del namespace Admin
     * ------------------------------------------------------------------
     */
    Route::group(['namespace' => 'Admin'], function () {
        /** Ruta para la configuración de la aplicación */
        Route::resource('settings', 'SettingController', [
            'except' => ['create', 'edit', 'show', 'update', 'destroy']
        ]);
        /** Rutas para la gestión de módulos de la aplicación */
        Route::group(['prefix' => 'modules'], function () {
            Route::get('list', 'ModuleController@index')->name('module.list');
            Route::post('enable', 'ModuleController@enable')->name('module.enable');
            Route::post('disable', 'ModuleController@disable')->name('module.disable');
            Route::post('details', 'ModuleController@getDetails')->name('module.details');
        });
        /** Ruta para la gestión de información sobre la(s) institución(es) */
        Route::resource('institutions', 'InstitutionController');

        /** Rutas para gestionar respaldos de la aplicación */
        Route::get('backup', 'BackupController@index')->name('backup.index');
        Route::get('backup/create', 'BackupController@create')->name('backup.create');
        Route::get('backup/download/{file_name}', 'BackupController@download')->name('backup.download');
        Route::get('backup/delete/{file_name}', 'BackupController@delete')->name('backup.delete');

        /** Obtiene las instituciones registradas */
        Route::get('get-institutions', 'InstitutionController@getInstitutions');
        Route::get(
            'get-institution/details/{institution}',
            'InstitutionController@getDetails'
        )->name('institution.details');
    });

    /**
     * ------------------------------------------------------------------
     * Grupo de rutas del namespace Auth
     * ------------------------------------------------------------------
     */
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
        /** Rutas para la configuración de usuarios, roles y permisos */
        Route::get('settings/users', 'UserController@index')->name('access.settings.users');
        Route::get('settings/roles-permissions', 'UserController@indexRolesPermissions')->name('access.settings');

        Route::get('get-roles-permissions', 'UserController@getRolesAndPermissions')->name('get.roles.permissions');

        /** Ruta de configuración de permisos asociados a los distintos roles del sistema */
        Route::post('settings/roles-permissions', 'UserController@setRolesAndPermissions')
             ->name('roles.permissions.settings');

        /** Ruta para la assignación de roles y permisos a usuarios del sistema */
        Route::get('assign/roles-permissions/{user}', 'UserController@assignAccess')->name('assign.access');
        Route::post('assign/roles-permissions', 'UserController@setAccess')->name('roles.permissions.assign');
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
Route::get('test', function () {
    /** @var string Familia de fuente a utilizar en el reporte */
    $fontFamily = 'helvetica';
    /** @var string Ruta en donde se encuentra ubicada la imagen del logotipo institucional */
    $imageFile = K_PATH_IMAGES."/logo.png";
    /** @var string Ruta en donde se encuentra el cintillo o banner institucional */
    $bannerFile = K_PATH_IMAGES."/cintillo.png";
    /** @var array Estilos a implementar en el código QR a generar */
    $qrCodeStyle = [
        'border' => false,
        'padding' => 0,
        'fgcolor' => [0,0,0],
        'bgcolor' => false
    ];
    $barCodeStyle = [
        'border' => 0,
        'vpadding' => 'auto',
        'hpadding' => 'auto',
        'fgcolor' => [0,0,0],
        'bgcolor' => false, //array(255,255,255)
        'module_width' => 1, // width of a single module in points
        'module_height' => 1 // height of a single module in points
    ];

    /** @var string Ruta de verificación del reporte mediante el código QR */
    $urlVerifyReport = 'www.tcpdf.org';
    /** @var string Título a mostrar en el reporte */
    $reportTitle = 'Título del Reporte';
    /** @var string Descripción o subtítulo del reporte */
    $reportDescription = 'Descripción breve del reporte';
    /** @var array Estilos a implementar en las líneas de separación entre las secciones del reporte */
    $lineStyle = ['width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => [0, 0, 0]];

    /** Configuración del encabezado del reporte */
    PDF::setHeaderCallback(function ($pdf) use (
        $fontFamily,
        $imageFile,
        $bannerFile,
        $barCodeStyle,
        $qrCodeStyle,
        $urlVerifyReport,
        $reportTitle,
        $reportDescription,
        $lineStyle
    ) {
        /** Imagen del banner institucional a implementar en el reporte */
        $pdf->Image($bannerFile, 10, 10, '', 10, '', '', 'T', false, 300, 'C', false, false, 0, false, false, true);
        /** Imagen del logotipo institucional a implementar en el reporte */
        $pdf->Image($imageFile, 10, 20, 25, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
        /** Configuración de la fuente para el título del reporte */
        $pdf->SetFont($fontFamily, 'B', 15);
        /** Título del reporte */
        $pdf->MultiCell(145, 7, $reportTitle, 0, 'C', false, 1, 40, 22, true, 0, false, true, 0, 'T', true);
        /** Código QR con enlace de verificación del reporte */
        $pdf->write2DBarcode($urlVerifyReport, 'QRCODE,H', 190, 22, 12, 12, $qrCodeStyle, 'T');
        /** Configuración de la fuente para la breve descripción del reporte */
        $pdf->SetFont($fontFamily, 'B', 12);
        /** Descripción breve del reporte */
        $pdf->MultiCell(72, 4, $reportDescription, 0, 'L', false, 1, 40, 30, true, 1, false, true, 0, 'T', true);
        /** Fecha de emisión del reporte */
        $pdf->MultiCell(72, 4, \Carbon\Carbon::now(), 0, 'R', false, 1, 113, 30, true, 1, false, true, 0, 'T', true);
        /** Línea de separación entre el encabezado del reporte y el cuerpo */
        $pdf->Line(7, 35, 205, 35, $lineStyle);

        /*$pdf->write1DBarcode(
        '$2y$10$syg39jYYUGB/PDi/i9MI5u53FMza75uWPaBmU8XtYrBgWuloA8Xva', 'C128', 80, 90, 60, 10, '', $barCodeStyle, 'N'
        );*/
        /*$pdf->write1DBarcode('1234567890', 'UPCA', 80, 90, 60, 10, '', $barCodeStyle, 'N');*/
        /*$pdf->write1DBarcode('1234567890', 'CODABAR', 80, 90, 60, 10, '', $barCodeStyle, 'N');*/
        /*$pdf->write1DBarcode('1234567890', 'CODE11', 80, 90, 60, 10, '', $barCodeStyle, 'N');*/
        //$pdf->Text(80, 85, 'PDF417 (ISO/IEC 15438:2006)');
        //
        //ESTE DE ACA ABAJO
        /*$pdf->write2DBarcode('www.tcpdf.org', 'PDF417,4,6,1,99998,,filename.txt', 80, 90, 60, 15, $barCodeStyle, 'N');
        $pdf->Text(80, 85, 'PDF417 (ISO/IEC 15438:2006)');*/
    });

    /** @var string Dirección o texto a mostrar en el pie de página del reporte */
    $footerText = 'Dirección o texto a mostrar';
    PDF::setFooterCallback(function ($pdf) use ($fontFamily, $footerText, $lineStyle) {
        /** @var Número de página del reporte [description] */
        $pageNumber = 'Pág. '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages();
        /** Posición a 14 mm del borde inferior de la página*/
        $pdf->SetY(-14);
        /** Configuración de la fuenta a utilizar */
        $pdf->SetFont($fontFamily, 'I', 8);
        /** Texto a mostrar en el pie de página del reporte */
        $pdf->MultiCell(198, 8, $footerText, 0, 'C', false, 1, 7, -12, true, 1, false, true, 0, 'T', true);
        /** Texto a mostrar para el número de página */
        $pdf->MultiCell(20, 4, $pageNumber, 0, 'R', false, 1, 185, -8, true, 1, false, true, 1, 'T', true);
        /** Línea de separación entre el cuerpo del reporte y el pie de página */
        $pdf->Line(7, 265, 205, 265, $lineStyle);
    });

    /** @var string Nombre del archivo bajo el cual se va a generar el reporte */
    $filename = 'my_file';
    /** @var string Datos a mostrar en el cuerpo del reporte */
    $html = 'texto a mostrar';
    /** Configuración sobre el autor del reporte */
    PDF::SetAuthor('Sistema de Gestión de Recursos - ' . config('app.name'));
    /** Configuración del título de reporte */
    PDF::SetTitle($reportTitle);
    /** Configuración sobre el asunto del reporte */
    PDF::SetSubject('Reporte del módulo de ...');
    /** Configuración de los márgenes del cuerpo del reporte */
    PDF::SetMargins(7, 40, 7);
    /** Establece si se configura o no las fuentes para sub configuraciones */
    PDF::SetFontSubsetting(false);
    /** Configuración de la fuente por defecto del cuerpo del reporte */
    PDF::SetFontSize('10px');
    /**
     * Configuración que permite realizar un salto de página automático al alcanzar el límite inferior del cuerpo
     * del reporte
     */
    PDF::SetAutoPageBreak(true, 15); //PDF_MARGIN_BOTTOM
    /** Agrega las respectivas páginas del reporte */
    PDF::AddPage('P', 'LETTER');
    /** Escribre el contenido del reporte */
    PDF::writeHTML($html, true, false, true, false, '');
    /** Establece el apuntador del reporte a la última página generada */
    PDF::lastPage();
    /**
     * Genera el reporte. Las opciones disponibles son:
     *
     * I: Genera el archivo directamente para ser visualizado en el navegador
     * D: Genera el archivo y forza la descarga del mismo
     * F: Guarda el archivo generado en la ruta del servidor establecida por defecto
     * S: Devuelve el documento generado como una cadena de texto
     * FI: Es equivalente a las opciones F + I
     * FD: Es equivalente a las opciones F + D
     * E: Devuelve el documento del tipo mime base64 para ser adjuntado en correos electrónicos
     */
    PDF::Output($filename . '.pdf', 'I');
});


Route::get('mail', function () {
    $user = App\User::find(1);

    return (new App\Notifications\UserRegistered($user, '123456'))
                ->toMail($user);
});
