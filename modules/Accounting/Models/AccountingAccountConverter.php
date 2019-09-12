<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Module;

/**
 * @class AccountingAccount
 * @brief Datos de cuentas del Clasificador Patrimoniales
 *
 * Modelo de la tabla pivot entre budget_account y accounting_account
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                LICENCIA DE SOFTWARE CENDITEL
 *            </a>
 */
class AccountingAccountConverter extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    protected $fillable = [
        'accounting_account_id',
        'budget_account_id',
        'active'
    ];

    /**
     * AccountingAccountConverter belongs to BudgetAccount.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budgetAccount()
    {
        return (Module::has('Budget'))? $this->belongsTo(\Modules\Budget\Models\BudgetAccount::class) : null;
    }

    /**
     * AccountingAccountConverter belongs to AccountingAccount.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accountingAccount()
    {
        return $this->belongsTo(AccountingAccount::class);
    }
}
