<?php

namespace Modules\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

/**
 * @class BudgetAditionalCreditAccount
 * @brief Datos de cuentas asociadas a los créditos adicionales
 *
 * Gestiona el modelo de datos para las cuentas de los créditos adicionales
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class BudgetAditionalCreditAccount extends Model implements Recordable
{
    use SoftDeletes;
    use RecordableTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'amount', 'budget_sub_specific_formulation_id', 'budget_account_id', 'budget_aditional_credit_id'
    ];

    /**
     * BudgetAditionalCreditAccount belongs to BudgetSpecificAction.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formulation()
    {
        return $this->belongsTo(BudgetSubSpecificFormulation::class);
    }

    /**
     * BudgetAditionalCreditAccount belongs to BudgetAccount.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(BudgetAccount::class);
    }

    /**
     * BudgetAditionalCreditAccount belongs to BudgetAditionalCredit.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aditionalCredit()
    {
        return $this->belongsTo(BudgetAditionalCredit::class);
    }
}
