<?php

namespace App\Roles\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Interface para la gestión de permisos y sus relaciones
 *
 * @author ultraware\roles <a href="https://github.com/ultraware/roles.git">Ultraware\Roles</a>
 */
interface PermissionHasRelations
{
    /**
     * Permission belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles();

    /**
     * Permission belongs to many users.
     *
     * @return BelongsToMany
     */
    public function users();
}
