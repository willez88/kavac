<?php

/** Proveedores de servicios generales del sistema */
namespace App\Providers;

//use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * @class AuthServiceProvider
 * @brief Proveedor de servicios de autenticación
 *
 * Gestiona los proveedores de servicios de autenticación
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @method  boot
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
