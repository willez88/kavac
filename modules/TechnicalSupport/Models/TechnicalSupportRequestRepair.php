<?php

namespace Modules\TechnicalSupport\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

class TechnicalSupportRequestRepair extends Model implements Auditable
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
    protected $fillable = ['technical_support_request_id', 'technical_support_repair_id'];

    /**
     * Método que obtiene la solicitud asociada al registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * TechnicalSupportRequest
     */
    public function technicalSupportRequest()
    {
        return $this->belongsTo(TechnicalSupportRequest::class);
    }

    /**
     * Método que obtiene la información de la reparación asociada al registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * TechnicalSupportRepair
     */
    public function technicalSupportRepair()
    {
        return $this->belongsTo(TechnicalSupportRepair::class);
    }

    /**
     * Método que obtiene los diagnósticos asociadas al registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * TechnicalSupportDiagnostic
     */
    public function technicalSupportDiagnostic()
    {
        return $this->belongsTo(TechnicalSupportDiagnostic::class);
    }
}
