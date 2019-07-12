<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class PurchaseSupplier
 * @brief Datos de los proveedores
 * 
 * Gestiona el modelo de datos para los proveedores
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PurchaseSupplier extends Model implements Auditable
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

    protected $with = [
    	'purchase_supplier_specialty', 'purchase_supplier_type', 'purchase_supplier_branch', 'purchase_supplier_object', 
        'phones', 'city'
    ];

    protected $fillable = [
    	'rif', 'code', 'name', 'direction', 'person_type', 'company_type', 'contact_name', 'contact_email', 'website', 'active',
    	'purchase_supplier_specialty_id', 'purchase_supplier_type_id', 'purchase_supplier_object_id', 
        'purchase_supplier_branch_id', 'city_id', 'rnc_status', 'rnc_certificate_number'
    ];

    /**
     * Get all of the budget project's specific actions.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function phones()
    {
        return $this->morphMany(\App\Models\Phone::class, 'phoneable');
    }

    /**
     * PurchaseSupplier belongs to PurchaseSupplierSpecialty.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchase_supplier_specialty()
    {
    	return $this->belongsTo(PurchaseSupplierSpecialty::class);
    }

    /**
     * PurchaseSupplier belongs to PurchaseSupplierType.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchase_supplier_type()
    {
    	return $this->belongsTo(PurchaseSupplierType::class);
    }

    /**
     * PurchaseSupplier belongs to City.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
    	return $this->belongsTo(City::class);
    }

    /**
     * PurchaseSupplier belongs to PurchaseSupplierBranch.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchase_supplier_branch()
    {
        return $this->belongsTo(PurchaseSupplierBranch::class);
    }

    /**
     * PurchaseSupplier belongs to PurchaseSupplierO.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchase_supplier_object()
    {
        return $this->belongsTo(PurchaseSupplierObject::class);
    }

}
