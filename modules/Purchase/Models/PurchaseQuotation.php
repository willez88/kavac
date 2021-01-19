<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

class PurchaseQuotation extends Model implements Auditable
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
    protected $fillable = [
        'code', 'status', 'purchase_supplier_id', 'purchase_base_budget_id', 'currency_id', 'subtotal'
    ];

    /**
     * PurchaseOrder belongs to PurchaseSupplier.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchaseSupplier()
    {
        // belongsTo(RelatedModel, foreignKey = purchaseSupplier_id, keyOnRelatedModel = id)
        return $this->belongsTo(PurchaseSupplier::class);
    }

    /**
     * PurchaseOrder belongs to Currency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        // belongsTo(RelatedModel, foreignKey = currency_id, keyOnRelatedModel = id)
        return $this->belongsTo(Currency::class);
    }

    /**
     * PurchaseQuotation has many Pivot.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pivot_recordable()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = purchaseQuotation_id, localKey = id)
        return $this->hasMany(Pivot::class, 'recordable_id');
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
}
