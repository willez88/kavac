<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class PurchaseSupplierType
 * @brief Datos de los tipos de proveedores
 *
 * Gestiona el modelo de datos para los tipos de proveedores
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PurchaseSupplierType extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;

    protected $revisionCreationsEnabled = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = ['name'];

    /**
     * City has many PurchaseSuppliers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseSuppliers()
    {
        return $this->hasMany(PurchaseSupplier::class);
    }

    /**
     * PurchaseSupplierType has many Purchase_requirements.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchase_requirements()
    {
        return $this->hasMany(PurchaseRequirement::class);
    }
}
