<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nombre de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Este valor es el nombre de tu aplicación. El valor es usado cuando el framework 
    | necesita colocar el nombre de la aplicación en una notificación o en cualquier otra 
    | localización requerida por la aplicación o por los paquetes.
    |
    */

    'name' => env('APP_NAME', 'KAVAC'),

    /*
    |--------------------------------------------------------------------------
    | Entorno de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Este valor determina el "entorno" que actualmente se esta ejecutando en la aplicación. 
    | Esto puede determinar como prefieres configurar varios servicios que utiliza la aplicación. 
    | Puedes verlo en tu archivo ".env".
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Modo de Depuración de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Cuando la aplicación esta en modo de depuración, se mostrarán mensajes de error detallados 
    | con información de los mismos y en que parte del sistema ocurrieron estos errores. 
    | Si lo desabilitas, se mostrará una página sencilla con el código de error generado e 
    | información básica del mismo.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | URL de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Esta URL es usada por la consola para generar URLs apropiadamente cuando usas 
    | el comando artisan en la herramienta de línea de comandos. Puedes configurar esto al 
    | root de la aplicación para ser usado cuando ejecutes tareas Artisan.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Modo demostración de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Permite establecer la aplicación en modo de demostración para probar y 
    | verificar sus funcionalidades
    |
    */

    'demo' => env('APP_DEMO', false),

    /*
    |--------------------------------------------------------------------------
    | Zona Horaria de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Aquí puedes indicar la zona horaria de la aplicación por defecto, esto puede ser 
    | usado por las funciones "date" y "date-time" de PHP. Por defecto se ha configurado 
    | la zona horaria a una configuración generalmente utilizada.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Configuración de Localización de la Aplicación
    |--------------------------------------------------------------------------
    |
    | La localización de la aplicación determina el lenguaje por defecto que puede ser 
    | usado por el service provider de traducción. Eres libre de configurar este valor 
    | a cualquiera de las localizaciones que son soportadas por la aplicación.
    |
    */

    'locale' => 'es',

    /*
    |--------------------------------------------------------------------------
    | Localización por defecto de la Aplicación
    |--------------------------------------------------------------------------
    |
    | La localización por defecto determina el lenguaje a usar cuando la configuración actual 
    | de la variable "locale" no esta disponible. Puedes modificar este valor a cualquiera de 
    | los que corresponda ubicados en la carpeta "language" provista para la aplicación.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Clave de Cifrado
    |--------------------------------------------------------------------------
    |
    | Esta clave es usada por el servicio de cifrado de Illuminate y debe ser configurada a una cadena 
    | aleatoria de 32 carácteres, de lo contrario esta cadena de cifrado puede no ser segura. 
    | Por favor configurela antes de desplegar la aplicación!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Proveedores de Servicios Autocargados
    |--------------------------------------------------------------------------
    |
    | Los proveedores de servicios listados aquí pueden ser cargados automáticamente en las 
    | peticiones de la aplicación. Sientete libre de agregar tú propio servicio a este arreglo 
    | para expandir las funcionalidades de la aplicación.
    |
    */

    'providers' => [

        /*
         * Proveedores de Servicios del Framework Laravel...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        Elibyy\TCPDF\ServiceProvider::class,

        /*
         * Proveedores de Servicios de Paquetes...
         */

        /*
         * Proveedores de Servicios de la Aplicación...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

        /**
         * Proveedores de Servicios de Terceros...
         */
        App\Roles\RolesServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Alias de Clases
    |--------------------------------------------------------------------------
    |
    | Este arreglo de alias de clases puede ser registrado cuando esta aplicación 
    | es inicializada. Sin embargo, sientete libre de registrar tantos alias necesites 
    | cargar ya que esto no impide el correcto desempeño de la aplicación.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        'PDF' => Elibyy\TCPDF\Facades\TCPDF::class,

    ],

];
