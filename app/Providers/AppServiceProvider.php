<?php

/** Proveedores de servicios generales del sistema */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use App\Models\NotificationSetting;
use App\Observers\ModelObserver;
use Nwidart\Modules\Module;

/**
 * @class AppServiceProvider
 * @brief Proveedor de servicios de la aplicación
 *
 * Gestiona los proveedores de servicios de la aplicación
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @method  register
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @method  boot
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        /*foreach (\Module::collections(1) as $module) {
            foreach (NotificationSetting::where('module', $module->getLowerName())->get() as $notifySetting) {
                $notifySetting::observe(ModelObserve::class);
                dd("entro");
            }
        }*/
        if (!app()->runningInConsole()) {
            /** Solo ejecuta esta instrucción si no se esta ejecutando en consola de comandos */
            foreach (NotificationSetting::all() as $notifySetting) {
                if (!is_null($notifySetting->module) && Module::isDisabled($notifySetting->module)) {
                    continue;
                }

                ($notifySetting->model)::observe(ModelObserver::class);
            }
        }
    }
}
