<?php

namespace Modules\Budget\Models;

use App\Models\Institution as BaseInstitution;

/**
 * @class Institution
 * @brief Modelo que extiende las funcionalidades del modelo base Institution
 *
 * Modelo que extiende las funcionalidades del modelo base Institution
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class Institution extends BaseInstitution
{
    /**
     * Institution has many BudgetSubSpecificFormulations.
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budgetSubSpecificFormulations()
    {
        return $this->hasMany(BudgetSubSpecificFormulation::class);
    }

    /**
     * Institution has many BudgetModification.
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budgetModifications()
    {
        return $this->hasMany(BudgetModification::class);
    }
}
