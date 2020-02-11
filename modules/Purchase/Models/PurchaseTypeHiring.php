<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

class PurchaseTypeHiring extends Model implements Auditable
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
    protected $fillable = ['date', 'active', 'purchase_type_operation_id', 'ut'];

    /**
     * PurchaseTypeHiring belongs to PurchaseTypeOperation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchaseTypeOperation()
    {
        // belongsTo(RelatedModel, foreignKey = purchaseTypeOperation_id, keyOnRelatedModel = id)
        return $this->belongsTo(PurchaseTypeOperation::class);
    }
}
