<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class NotificationSetting
 * @brief Datos de configuración de notificaciones
 *
 * Gestiona la configuración de notificaciones para los usuarios del sistema
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class NotificationSetting extends Model
{
    /**
     * Lista de atributos para la gestión de fechas
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['module', 'module_name', 'model', 'name', 'slug', 'description', 'perm_required'];

    /**
     * NotificationSetting belongs to Many Users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('type')->withTimestamps();
    }
}
