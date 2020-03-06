<?php

namespace Modules\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class BudgetStage
 * @brief Datos de las etapas presupuestarias
 *
 * Gestiona el modelo de datos para las etapas presupuestarias:
 * Precompromiso = PRE
 * Programado = PRO
 * Comprometido = COM
 * Causado = CAU
 * Pagado = PAG
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class BudgetStage extends Model implements Auditable
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
     * BudgetStage morphs to models in sourceable_type.
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function sourceable()
    {
        return $this->morphTo();
    }

    /**
     * BudgetStage belongs to BudgetCompromise.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function budgetCompromise()
    {
        return $this->belongsTo(BudgetCompromise::class);
    }
}
