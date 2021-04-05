<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class PurchaseStage
 * @brief Datos de las etapas del compromiso
 *
 * Gestiona el modelo de datos para las etapas del compromiso:
 * Precompromiso = PRE
 * Programado = PRO
 * Comprometido = COM
 * Causado = CAU
 * Pagado = PAG
 *
 * @author Ing. Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PurchaseStates extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;
    use ModelsTrait;

    /**
     * Lista de atributos para la gestión de fechas
     * @var array $dates
     */
    protected $dates = ['deleted_at', 'registered_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['code', 'registered_at', 'type', 'amount', 'budget_compromise_id'];

    /**
     * PurchaseStage morphs to models in stageable_type.
     *
     * @author Ing. Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function stageable()
    {
        return $this->morphTo();
    }

    /**
     * PurchaseStage belongs to BudgetCompromise.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function budgetCompromise()
    {
        return $this->belongsTo(PurchaseCompromise::class);
    }
}
