<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

class PurchaseType extends Model implements Auditable
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
    protected $fillable = ['name', 'description', 'purchase_processes_id'];

    /**
     * PurchaseType belongs to PurchaseProcess.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchaseProcess()
    {
        // belongsTo(RelatedModel, foreignKey = purchaseProcess_id, keyOnRelatedModel = id)
        return $this->belongsTo(PurchaseProcess::class, 'purchase_processes_id');
    }

    /**
     * PurchaseType has many PurchasePlan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchasePlan()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = purchaseType_id, localKey = id)
        return $this->hasMany(PurchasePlan::class);
    }
}
