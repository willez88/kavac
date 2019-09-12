<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class PurchaseRequirementItem
 * @brief Datos de los productos o servicios en los requerimientos de compras
 *
 * Gestiona el modelo de datos para los productos o servicios en los requerimientos de compra
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PurchaseRequirementItem extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description', 'technical_specifications', 'quantity', 'measurement_unit_id',
        'warehouse_product_id', 'purchase_requirement_id'
    ];

    /**
     * PurchaseRequirementItem belongs to PurchaseRequirement.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchaseRequirement()
    {
        return $this->belongsTo(PurchaseRequirement::class);
    }
}
