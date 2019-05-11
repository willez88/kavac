<?php

namespace Modules\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class BudgetAccountOpen
 * @brief Datos de cuentas formuladas en presupuesto
 * 
 * Gestiona el modelo de datos para las cuentas formuladas en presupuesto
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class BudgetAccountOpen extends Model implements Auditable
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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'jan_amount', 'feb_amount', 'mar_amount', 'apr_amount', 'may_amount', 'jun_amount', 
    	'jul_amount', 'aug_amount', 'sep_amount', 'oct_amount', 'nov_amount', 'dec_amount',
    	'total_year_amount', 'total_real_amount', 'total_estimated_amount', 'budget_account_id',
    	'budget_sub_specific_formulation_id'
    ];

    /**
     * BudgetAccountOpen belongs to BudgetAccount.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function budget_account()
    {
    	return $this->belongsTo(BudgetAccount::class);
    }

    /**
     * BudgetAccountOpen belongs to BudgetSubSpecificFormulation.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sub_specific_formulation()
    {
    	return $this->belongsTo(BudgetSubSpecificFormulation::class);
    }
}
