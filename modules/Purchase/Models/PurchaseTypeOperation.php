<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

class PurchaseTypeOperation extends Model implements Auditable
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
    protected $fillable = ['name', 'description'];

    /**
     * PurchaseTypeOperation has many PurchaseTypeHiring.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseTypeHiring()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = purchaseTypeOperation_id, localKey = id)
        return $this->hasMany(PurchaeTypeHiring::class);
    }
}
