<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Department as BaseDepartment;

/**
 * @class      Department
 * @brief      Datos de departamento
 *
 * Gestiona el modelo de departamentos
 *
 * @author     William Páez <wpaez@cenditel.gob.ve>
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class Department extends BaseDepartment
{
    /**
     * Método que obtiene el departamento asociado a muchas informaciones laborales del trabajador
     *
     * @author    William Páez <wpaez@cenditel.gob.ve>
     * @return    \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollEmploymentInformations()
    {
        return $this->hasMany(PayrollEmploymentInformation::class);
    }

    /**
     * Obtiene información de las opciones asignadas asociadas a un departamento
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payrollConceptAssignOptions()
    {
        return $this->morphMany(PayrollConceptAssignOption::class, 'assignable');
    }
}
