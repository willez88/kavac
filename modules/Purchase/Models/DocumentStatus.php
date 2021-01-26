<?php
/** [descripción del namespace] */
namespace Modules\Purchase\Models;

use App\Models\DocumentStatus as BaseDocumentStatus;

/**
 * @class DocumentStatus
 * @brief Modelo que extiende las funcionalidades del modelo base DocumentStatus
 *
 * Modelo que extiende las funcionalidades del modelo base DocumentStatus
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
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
