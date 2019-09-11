<?php

namespace Modules\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

/**
 * @class BudgetAccountOpen
 * @brief Datos de cuentas formuladas en presupuesto
 *
 * Gestiona el modelo de datos para las cuentas formuladas en presupuesto
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class BudgetAccountOpen extends Model implements Recordable
{
    use SoftDeletes;
    use RecordableTrait;

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
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function budgetAccount()
    {
        return $this->belongsTo(BudgetAccount::class);
    }

    /**
     * BudgetAccountOpen belongs to BudgetSubSpecificFormulation.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subSpecificFormulation()
    {
        return $this->belongsTo(BudgetSubSpecificFormulation::class);
    }
}
