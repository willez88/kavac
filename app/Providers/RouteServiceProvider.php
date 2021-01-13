<?php
/** Proveedores de servicios generales del sistema */
namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

/**
 * @class AppServiceProvider
 * @brief Proveedor de servicios de las rutas
 *
 * Gestiona los proveedores de servicios de las rutas
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @method  boot
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            /** Rutas generales para la gestión de módulos */
            Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/module.php'));

            /** Rutas para la gestión esclusiva del administrador de la aplicación */
            Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/admin.php'));

            if (config('app.debug') || config('app.debug')==="true") {
                /** Rutas para pruebas de desarrollo */
                Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/test.php'));
            }
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @method  configureRateLimiting
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
}
