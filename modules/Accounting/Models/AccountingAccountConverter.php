<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Modules\Accounting\Models\BudgetAccount;
/**
 * @class AccountingAccount
 * @brief Datos de cuentas del Clasificador Patrimoniales
 * 
 * Modelo de la tabla pivot entre budget_account y accounting_account
 * 
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingAccountConverter extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
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
    public function budget_account()
    {
        return $this->belongsTo(BudgetAccount::class);
    }

    /**
     * AccountingAccountConverter belongs to AccountingAccount.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounting_account()
    {
        return $this->belongsTo(AccountingAccount::class);
    }


}
