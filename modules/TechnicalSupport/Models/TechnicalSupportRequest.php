<?php

namespace Modules\TechnicalSupport\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class TechnicalSupportRequest
 * @brief Datos de las solicitudes registradas.
 *
 * Gestiona el modelo de datos de las solicitudes de reparación de bienes institucionales.
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class TechnicalSupportRequest extends Model implements Auditable
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
    protected $fillable = ['state', 'description', 'user_id', 'asset_id'];

    /**
     * Método que obtiene el usuario que genera la solicitud de reparación
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo User
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * Método que obtiene el bien asociado a la solicitud.
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo Asset
     */
    public function asset()
    {
        return $this->belongsTo(\Modules\Asset\Models\Asset::class);
    }

    /**
     * Método que obtiene las solicitudes de reparación asociadas al registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne Objeto con el registro relacionado al modelo
     * TechnicalSupportRequestRepair
     */
    public function technicalSupportRequestRepair()
    {
        return $this->hasOne(TechnicalSupportRequestRepair::class);
    }
}
