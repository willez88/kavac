<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

class PurchaseProcess extends Model implements Auditable
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
    protected $fillable = ['name', 'description', 'require_documents', 'list_documents'];

    /**
     * PurchaseProcess has many PurchaseType.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseType()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = purchaseProcess_id, localKey = id)
        return $this->hasMany(PurchaeType::class);
    }

    /**
     * PurchaseProcess has many PurchasePlan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchasePlan()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = purchaseProcess_id, localKey = id)
        return $this->hasMany(PurchasePlan::class);
    }
}
