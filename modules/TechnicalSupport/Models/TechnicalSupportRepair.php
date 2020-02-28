<?php

namespace Modules\TechnicalSupport\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class TechnicalSupportRepair
 * @brief Datos de las reparaciones registradas.
 *
 * Gestiona el modelo de datos de las reparaciones de bienes institucionales.
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class TechnicalSupportRepair extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;
    use ModelsTrait;

    /**
     * Lista de atributos para la gestión de fechas
     *
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = [
        'state', 'start_date', 'end_date', 'user_id'
    ];

    /**
     * Método que obtiene las solicitudes de reparación asociadas al registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado
     * al modelo TechnicalSupportRequestRepair
     */
    public function technicalSupportRequestRepairs()
    {
        return $this->hasMany(TechnicalSupportRequestRepair::class);
    }

    /**
     * Método que obtiene el usuario responsable de la reparación
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado
     * al modelo TechnicalSupportRequestRepair
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
