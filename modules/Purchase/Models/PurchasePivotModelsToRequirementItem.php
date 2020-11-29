<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

class PurchasePivotModelsToRequirementItem extends Model implements Auditable
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
                            'purchase_requirement_item_id',
                            'unit_price',
                            'relatable_type',
                            'relatable_id',
                        ];

    /**
     * PurchasePivotModelsToRequirementItem morphs to models in relatable_type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function relatable()
    {
        // morphTo($name = relatable, $type = relatable_type, $id = relatable_id)
        // requires relatable_type and relatable_id fields on $this->table
        return $this->morphTo();
    }

    /**
     * PurchasePivotModelsToRequirementItem belongs to PurchaseRequirementItem.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchaseRequirementItem()
    {
        // belongsTo(RelatedModel, foreignKey = purchaseRequirementItem_id, keyOnRelatedModel = id)
        return $this->belongsTo(PurchaseRequirementItem::class);
    }
}
