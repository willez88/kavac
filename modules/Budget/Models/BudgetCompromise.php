<?php

namespace Modules\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class BudgetCompromise
 * @brief Datos de los compromisos presupuestarios
 *
 * Gestiona el modelo de datos para los Compromisos de Presupuesto
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class BudgetCompromise extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'compromised_at'];

    protected $fillable = ['compromised_at', 'description', 'code', 'document_status_id'];

    /**
     * Compromise morphs to models in compromiseable_type.
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function compromiseable()
    {
        return $this->morphTo();
    }

    /**
     * Compromise morphs to models in sourceable_type.
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function sourceable()
    {
        return $this->morphTo();
    }

    /**
     * BudgetCompromise has many BudgetCompromiseDetail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budgetCompromiseDetails()
    {
        return $this->hasMany(BudgetCompromiseDetail::class);
    }

    /**
     * BudgetCompromise has many BudgetStages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budgetStages()
    {
        return $this->hasMany(BudgetStage::class);
    }

    /**
     * BudgetCompromise belongs to DocumentStatus.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function documentStatus()
    {
        return $this->belongsTo(DocumentStatus::class);
    }
}
