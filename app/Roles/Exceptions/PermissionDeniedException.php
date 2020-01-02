<?php

namespace App\Roles\Exceptions;

/**
 * @class PermissionDeniedException
 * @brief Excepciones para los permisos de acceso denegados
 *
 * Gestiona las excepciones para los permisos de acceso denegados
 *
 * @author ultraware\roles <a href="https://github.com/ultraware/roles.git">Ultraware\Roles</a>
 */
class PermissionDeniedException extends AccessDeniedException
{
    /**
     * Create a new permission denied exception instance.
     *
     * @param string $permission
     */
    public function __construct($permission)
    {
        parent::__construct($permission);
        $this->message = __('You don\'t have a required [:permission] permission.', ['permission' => $permission]);
    }
}
