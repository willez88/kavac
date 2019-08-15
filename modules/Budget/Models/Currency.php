<?php

namespace Modules\Budget\Models;

use App\Models\Currency as BaseCurrency;

class Currency extends BaseCurrency
{
    /**
     * Department has many BudgetProjects.
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budget_sub_specific_formulations()
    {
        return $this->hasMany(BudgetSubSpecificFormulation::class);
    }
}
