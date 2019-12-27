<?php

namespace Modules\TechnicalSupport\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class TechnicalSupportRepairDiagnostic
 * @brief Datos de los diagnósticos de las reparación de bienes institucionales.
 *
 * Gestiona el modelo de datos de los diagnósticos de las reparación de bienes institucionales.
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class TechnicalSupportRepairDiagnostic extends Model implements Auditable
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
    protected $fillable = ['description', 'technical_support_repair_id'];

    /**
     * Método que obtiene la reparación asociada al diagnóstico
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * TechnicalSupportRepair
     */
    public function technicalSupportRepair()
    {
        return $this->belongsTo(TechnicalSupportRepair::class);
    }
}
