<?php

namespace Modules\Budget\Models;

use App\Models\DocumentStatus as BaseDocumentStatus;

class DocumentStatus extends BaseDocumentStatus
{
    /**
     * DocumentStatus has many BudgetSubSpecificFormulations.
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budgetSubSpecificFormulations()
    {
        return $this->hasMany(BudgetSubSpecificFormulation::class);
    }

    /**
     * DocumentStatus has many BudgetModifications.
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budgetModifications()
    {
        return $this->hasMany(BudgetModification::class);
    }

    /**
     * DocumentStatus has many BudgetCompromise.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budgetCompromise()
    {
        return $this->hasMany(BudgetCompromise::class);
    }
}
