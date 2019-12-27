<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class PurchaseRequirement
 * @brief Datos de los requerimientos de compras
 *
 * Gestiona el modelo de datos para los requerimientos de compra
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PurchaseRequirement extends Model implements Auditable
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
        'code', 'description', 'fiscal_year_id', 'contracting_department_id', 'user_department_id',
        'purchase_supplier_type_id', 'requirement_status'
    ];

    /**
     * PurchaseRequirement belongs to FiscalYear.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class);
    }

    /**
     * PurchaseRequirement belongs to ContratingDepartment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contratingDepartment()
    {
        return $this->belongsTo(Department::class, 'contracting_department_id');
    }

    /**
     * PurchaseRequirement belongs to UserDepartment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userDepartment()
    {
        return $this->belongsTo(Department::class, 'user_department_id');
    }

    /**
     * PurchaseRequirement belongs to PurchaseSupplierType.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchaseSupplierType()
    {
        return $this->belongsTo(PurchaseSupplierType::class);
    }

    /**
     * PurchaseRequirement has many PurchaseRequirementItems.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseRequirementItems()
    {
        return $this->hasMany(PurchaseRequirementItem::class);
    }
}
