<?php

namespace App\Roles\Exceptions;

/**
 * @class RoleDeniedException
 * @brief Excepciones para los roles de acceso denegados
 *
 * Gestiona las excepciones para los roles de acceso denegados
 *
 * @author ultraware\roles <a href="https://github.com/ultraware/roles.git">Ultraware\Roles</a>
 */
class RoleDeniedException extends AccessDeniedException
{
    /**
     * Create a new role denied exception instance.
     *
     * @param string $role
     */
    public function __construct($role)
    {
        parent::__construct($role);
        $this->message = __('You don\'t have a required [:role] role.', ['role' => $role]);
    }
}
