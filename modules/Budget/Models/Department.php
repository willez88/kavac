<?php

namespace Modules\Budget\Models;

use App\Models\Department as BaseDepartment;

class Department extends BaseDepartment
{
    /**
     * Department has many BudgetProjects.
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budgetProjects()
    {
        return $this->hasMany(BudgetProject::class);
    }

    /**
     * Department has many BudgetCentralizedAction.
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budgetCentralizedActions()
    {
        return $this->hasMany(BudgetCentralizedAction::class);
    }
}
