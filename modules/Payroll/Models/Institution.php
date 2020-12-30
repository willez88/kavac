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

    /**
     * Método que obtiene la información de la política vacacional asociada a la institución
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollVacationPolicies()
    {
        return $this->hasMany(PayrollVacationPolicy::class);
    }

    /**
     * Método que obtiene la información de las solicitudes de vacaciones asociados a la institución
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollVacationRequests()
    {
        return $this->hasMany(PayrollVacationRequest::class);
    }

    /**
     * Método que obtiene la información de la política de prestaciones asociada a la institución
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollBenefitsPolicies()
    {
        return $this->hasMany(PayrollBenefitsPolicy::class);
    }

    /**
     * Método que obtiene la información de las solicitudes de adelanto de prestaciones asociados a la institución
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollBenefitsRequests()
    {
        return $this->hasMany(PayrollBenefitsRequest::class);
    }
}
