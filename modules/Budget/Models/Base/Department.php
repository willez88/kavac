<?php

namespace Modules\Budget\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Models\Department as BaseDepartment;

class Department extends BaseDepartment
{
    /**
     * Department has many BudgetProjects.
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budget_projects()
    {
        return $this->hasMany(\Modules\Budget\Models\BudgetProject::class);
    }

    /**
     * Department has many BudgetCentralizedAction.
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budget_centralized_actions()
    {
        return $this->hasMany(\Modules\Budget\Models\BudgetCentralizedAction::class);
    }
}
