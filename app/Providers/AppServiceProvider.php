<?php

/** Proveedores de servicios generales del sistema */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\NotificationSetting;
use App\Observers\ModelObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
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
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        /*foreach (\Module::collections(1) as $module) {
            foreach (NotificationSetting::where('module', $module->getLowerName())->get() as $notifySetting) {
                $notifySetting::observe(ModelObserve::class);
                dd("entro");
            }
        }*/
        foreach (NotificationSetting::all() as $notifySetting) {
            if (!is_null($notifySetting->module) && \Module::isDisabled($notify->module)) {
                continue;
            }
            ($notifySetting->model)::observe(ModelObserver::class);
        }
    }
}
