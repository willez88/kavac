<?php

namespace Modules\TechnicalSupport\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class TechnicalSupportRequestRepair
 * @brief Datos de las solicitudes de reparación de bienes institucionales.
 *
 * Gestiona el modelo de datos de las solicitudes de reparación de bienes institucionales.
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
        'state', 'result', 'start_date', 'end_date', 'user_id', 'technical_support_request_repair_id'
    ];

    /**
     * Método que obtiene la solicitud asociada a la reparación
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * TechnicalSupportRequestRepair
     */
    public function technicalSupportRequestRepair()
    {
        return $this->belongsTo(TechnicalSupportRequestRepair::class);
    }

    /**
     * Método que obtiene el usuario responsable de la reparación
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo User
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
