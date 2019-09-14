<?php

namespace Modules\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class BudgetModificationAccount
 * @brief Datos de las cuentas de las modificaciones presupuestarias
 *
 * Gestiona el modelo de datos para las cuentas asociadas a las modificaciones presupuestarias
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class BudgetModificationAccount extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    /** @var array Establece las relaciones por defecto que se retornan con las consultas */
    protected $with = ['budgetAccount', 'budgetSubSpecificFormulation'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'amount', 'operation', 'budget_sub_specific_formulation_id', 'budget_account_id', 'budget_modification_id'
    ];

    /**
     * BudgetModificationAccount belongs to BudgetModification.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function budgetModification()
    {
        return $this->belongsTo(BudgetModification::class);
    }

    /**
     * BudgetModificationAccount belongs to BudgetAccount.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function budgetAccount()
    {
        return $this->belongsTo(BudgetAccount::class);
    }

    /**
     * BudgetModificationAccount belongs to BudgetSubSpecificFormulation.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function budgetSubSpecificFormulation()
    {
        return $this->belongsTo(BudgetSubSpecificFormulation::class);
    }
}
