<?php

namespace Modules\Accounting\Models;

use Modules\Budget\Models\BudgetAccount as BaseBudgetAccount;

/**
 * @class BudgatAccount
 * @brief Datos de cuentas del Clasificador Presupuestales
 *
 * Gestiona el modelo de datos para las cuentas del Clasificador Presupuestales desde el modulo de contabilidad
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class BudgetAccount extends BaseBudgetAccount
{
    /**
     * BudgetAccount morphs many Accountable.
     *
     * @author    Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function accountable()
    {
        // morphMany(MorphedModel, morphableName, type = able_type, relatedKeyName = able_id, localKey = id)
        return $this->morphMany(Accountable::class, 'accountable');
    }

    /**
     * BudgetAccount morphs many AccountingEntryable.
     *
     * @author    Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function accounting_entryable()
    {
        // morphMany(MorphedModel, morphableName, type = able_type, relatedKeyName = able_id, localKey = id)
        return $this->morphMany(AccountingEntryable::class, 'accounting_entryable');
    }
}
