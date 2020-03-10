<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

class PurchaseOrder extends Model implements Auditable
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
    protected $fillable = ['purchase_supplier_id', 'currency_id', 'subtotal'];

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
     * PurchaseOrder has many PurchaseRequirement.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseRequirement()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = purchaseOrder_id, localKey = id)
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
}
