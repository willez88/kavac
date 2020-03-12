<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

use Modules\Purchase\Models\PurchasePivotModelsToRequirementItem;

class PurchaseBaseBudget extends Model implements Auditable
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
    protected $fillable = ['currency_id', 'subtotal'];

    /**
     * PurchaseBaseBudget belongs to Currency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        // belongsTo(RelatedModel, foreignKey = currency_id, keyOnRelatedModel = id)
        return $this->belongsTo(Currency::class);
    }

    /**
     * PurchaseBaseBudget has many PurchaseRequirements.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseRequirements()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = purchaseBaseBudget_id, localKey = id)
        return $this->hasMany(PurchaseRequirement::class);
    }

    /**
     * PurchaseBaseBudget morphs many PurchasePivotModelsToRequirementItem.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function relatable()
    {
        // morphMany(MorphedModel, morphableName, type = able_type, relatedKeyName = able_id, localKey = id)
        return $this->morphMany(PurchasePivotModelsToRequirementItem::class, 'relatable');
    }

    /**
     * PurchaseBaseBudget has many PurchaseEstimates.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseQuotations()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = purchaseBaseBudget_id, localKey = id)
        return $this->hasMany(PurchaseEstimates::class);
    }
}
