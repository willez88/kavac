<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

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
    protected $fillable = ['currency_id', 'tax_id', 'purchase_requirement_item_id','unit_price', 'purchase_requirement_id'];

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
     * PurchaseBaseBudget belongs to Tax.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tax()
    {
        // belongsTo(RelatedModel, foreignKey = tax_id, keyOnRelatedModel = id)
        return $this->belongsTo(Tax::class);
    }
    /**
     * PurchaseBaseBudget has many PurchaseRequirement.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseRequirement()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = purchaseBaseBudget_id, localKey = id)
        return $this->hasMany(PurchaseRequirement::class);
    }

    /**
     * PurchaseBaseBudget belongs to PurchaseRequirementItem.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchaseRequirementItem()
    {
        // belongsTo(RelatedModel, foreignKey = purchaseRequirementItem_id, keyOnRelatedModel = id)
        return $this->belongsTo(PurchaseRequirementItem::class);
    }
}
