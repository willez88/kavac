<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Models\BudgetAccount;
/**
 * @class AccountingAccount
 * @brief Datos de cuentas del Clasificador Patrimoniales
 * 
 * Modelo de la tabla pivot entre budget_account y accounting_account
 * 
 * @author Juan Rosas <JuanFBass17@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingAccountConverter extends Model
{
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
