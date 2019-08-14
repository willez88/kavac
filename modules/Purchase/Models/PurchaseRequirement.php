<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
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
    use RevisionableTrait;
    use AuditableTrait;

    protected $revisionCreationsEnabled = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'code', 'description', 'fiscal_year_id', 'contracting_department_id', 'user_department_id',
        'purchase_supplier_type_id'
    ];

    /**
     * PurchaseRequirement belongs to Fiscal_year.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fiscal_year()
    {
        return $this->belongsTo(FiscalYear::class);
    }

    /**
     * PurchaseRequirement belongs to Contrating_department.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contrating_department()
    {
        return $this->belongsTo(Department::class, 'contracting_department_id');
    }

    /**
     * PurchaseRequirement belongs to User_department.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_department()
    {
        return $this->belongsTo(Department::class, 'user_department_id');
    }

    /**
     * PurchaseRequirement belongs to Purchase_supplier_type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchase_supplier_type()
    {
        return $this->belongsTo(PurchaseSupplierType::class);
    }

    /**
     * PurchaseRequirement has many Purchase_requirement_items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchase_requirement_items()
    {
        return $this->hasMany(PurchaseRequirementItem::class);
    }
}
