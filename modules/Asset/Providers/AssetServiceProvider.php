<?php

namespace Modules\Asset\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        /**
         * Se ejecuta antes de que se procese el trabajo
         */

        Queue::before(function (JobProcessing $event) {
            // echo "before";
            // Acceder al reporte del trabajo y cambiar estatus de
            // pendiente por ejecutar a en proceso
        });

        /**
         * Se ejecuta despues de que se procesa el trabajo
         */
        
        Queue::after(function (JobProcessed $event) {
            //$data = $event->job->payload;
            //echo get_class($event->job->getRawBody());
            //echo 'data' . get_class($data);
            // echo "after";
            // Acceder al reporte del trabajo y cambiar estatus de
            // en proceso a terminado
            // Lanzar evento descrito en el trabajo (abrir al finalizar o forzar descarga)
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('asset.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php',
            'asset'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/asset');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/asset';
        }, \Config::get('view.paths')), [$sourcePath]), 'asset');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/asset');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'asset');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'asset');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
