<?php

namespace App\Roles\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Roles\Exceptions\LevelDeniedException;

/**
 * @class VerifyLevel
 * @brief Verifica niveles de acceso
 *
 * Gestiona la verificación del nivel de acceso
 *
 * @author ultraware\roles <a href="https://github.com/ultraware/roles.git">Ultraware\Roles</a>
 */
class VerifyLevel
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
     * @param string $level
     *
     * @return mixed
     *
     * @throws \App\Roles\Exceptions\LevelDeniedException
     */
    public function handle($request, Closure $next, $level)
    {
        if ($this->auth->check() && $this->auth->user()->level() >= $level) {
            return $next($request);
        }

        throw new LevelDeniedException((string)$level);
    }
}
