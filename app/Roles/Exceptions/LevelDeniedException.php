<?php

namespace App\Roles\Exceptions;

/**
 * @class LevelDeniedException
 * @brief Excepciones para niveles de acceso denegados
 *
 * Gestiona las excepciones para los niveles de acceso denegados
 *
 * @author ultraware\roles <a href="https://github.com/ultraware/roles.git">Ultraware\Roles</a>
 */
class LevelDeniedException extends AccessDeniedException
{
    /**
     * Create a new level denied exception instance.
     *
     * @param string $level
     */
    public function __construct($level)
    {
        parent::__construct($level);
        $this->message = __('You don\'t have a required [:level] level.', ['level' => $level]);
    }
}
