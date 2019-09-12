<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class PurchaseSupplierSpecialty
 * @brief Datos de las especialidades de proveedores
 *
 * Gestiona el modelo de datos para las especialidades de los proveedores
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PurchaseSupplierSpecialty extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'description'];

    /**
     * City has many PurchaseSuppliers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseSuppliers()
    {
        return $this->hasMany(PurchaseSupplier::class);
    }
}
