<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Models\BudgetAccount as BaseBudgetAccount;

/**
 * @class BudgatAccount
 * @brief Datos de cuentas del Clasificador Presupuestales
 *
 * Gestiona el modelo de datos para las cuentas del Clasificador Presupuestales desde el modulo de contabilidad
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                LICENCIA DE SOFTWARE CENDITEL
 *            </a>
 */
class BudgetAccount extends BaseBudgetAccount
{
    /**
     * BudgetAccount morphs to many (many-to-many) accountingAccount.
     *
     * @author    Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function accountingAccounts()
    {
        // morphToMany(RelatedModel, morphName, pivotTable = ables, thisKeyOnPivot = able_id, otherKeyOnPivot = accountingAccount_id)
        return $this->morphToMany(AccountingAccount::class, 'accountable');
    }
}


