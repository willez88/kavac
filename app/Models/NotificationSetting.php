<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

/**
 * @class NotificationSetting
 * @brief Datos de configuración de notificaciones
 *
 * Gestiona la configuración de notificaciones para los usuarios del sistema
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('type');
    }
}
