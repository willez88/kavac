<?php

namespace Modules\Payroll\Models;

use App\Models\Department as BaseDepartment;

/**
 * @class      Department
 * @brief      Datos de departamento
 *
 * Gestiona el modelo de departamentos
 *
 * @author     William Páez <wpaez@cenditel.gob.ve>
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class Department extends BaseDepartment
{
    /**
     * Método que obtiene el departamento asociado a muchos datos laborales del trabajador
     *
     * @author    William Páez <wpaez@cenditel.gob.ve>
     * @return    \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollEmployments()
    {
        return $this->hasMany(PayrollEmployment::class);
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
