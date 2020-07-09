<?php

namespace Modules\Payroll\Models;

use App\Models\Institution as BaseInstitution;

/**
 * @class      Institution
 * @brief      Modelo que extiende las funcionalidades del modelo base Institution
 *
 * Modelo que extiende las funcionalidades del modelo base Institution
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class Institution extends BaseInstitution
{
    /**
     * Método que obtiene la información de los conceptos asociados a la institución
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollConcepts()
    {
        return $this->hasMany(PayrollConcept::class);
    }
}
