<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class Receiver
 * @brief Datos de receptores de procesos
 *
 * Gestiona el modelo de datos para los receptores de procesos dentro del sistema
 *
 * @property  string $group
 * @property  string $description
 * @property  string $receiverable_type
 * @property  string $receiverable_id
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class Receiver extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = ['group', 'description', 'receiverable_type', 'receiverable_id'];

    /**
     * Lista de atributos para la gestión de fechas
     *
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Oculta los campos de fechas de creación, actualización y eliminación
     *
     * @var    array $hidden
     */
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Receiver morphs to models in receiverable_type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function receiverable()
    {
        return $this->morphTo();
    }
}
