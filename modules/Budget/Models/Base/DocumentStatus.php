<?php

namespace Modules\Budget\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Models\DocumentStatus as BaseDocumentStatus;

class DocumentStatus extends BaseDocumentStatus
{
    /**
     * DocumentStatus has many BudgetSubSpecificFormulations.
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budget_sub_specific_formulations()
    {
        return $this->hasMany(\Modules\Budget\Models\BudgetSubSpecificFormulation::class);
    }

    /**
     * DocumentStatus has many BudgetModifications.
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budget_modifications()
    {
        return $this->hasMany(\Modules\Budget\Models\BudgetModification::class);
    }
}
