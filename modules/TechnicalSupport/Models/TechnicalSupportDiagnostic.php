<?php

namespace Modules\TechnicalSupport\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class TechnicalSupportDiagnostic
 * @brief Datos de los diagnósticos de las reparaciones de bienes institucionales.
 *
 * Gestiona el modelo de datos de los diagnósticos de las reparaciones de bienes institucionales.
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class TechnicalSupportDiagnostic extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;
    use ModelsTrait;

    /**
     * Lista de atributos para la gestión de fechas

     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente

     * @var array $fillable
     */
    protected $fillable = ['description', 'technical_support_request_repair_id'];

    /**
     * Método que obtiene la solicitud de reparación asociada al registro
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
