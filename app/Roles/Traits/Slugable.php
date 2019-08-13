<?php

namespace App\Roles\Traits;

use Illuminate\Support\Str;

/**
 * Trait para la gestión de slugs
 *
 * @author ultraware\roles <a href="https://github.com/ultraware/roles.git">Ultraware\Roles</a>
 */
trait Slugable
{
    /**
     * Set slug attribute.
     *
     * @param string $value
     * @return void
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value, config('roles.separator'));
    }
}
