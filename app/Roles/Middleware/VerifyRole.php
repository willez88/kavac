<?php

namespace App\Roles\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Roles\Exceptions\RoleDeniedException;

/**
 * @class VerifyRole
 * @brief Verifica roles de acceso
 *
 * Gestiona la verificación del rol de acceso
 *
 * @author ultraware\roles <a href="https://github.com/ultraware/roles.git">Ultraware\Roles</a>
 */
class VerifyRole
{
    /**
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @param string $role
     *
     * @return mixed
     *
     * @throws RoleDeniedException
     */
    public function handle($request, Closure $next, $role)
    {
        if ($this->auth->check() && $this->auth->user()->hasRole($role)) {
            return $next($request);
        }

        throw new RoleDeniedException($role);
    }
}
