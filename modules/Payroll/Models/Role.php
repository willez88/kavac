<?php

namespace Modules\Payroll\Models;

use App\Roles\Models\Role as BaseRole;

/**
 * @class      Role
 * @brief      Datos de roles
 *
 * Gestiona el modelo de roles
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class Role extends BaseRole
{
    /**
     * Obtiene información de las opciones asignadas asociadas a un rol
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payrollConceptAssignOptions()
    {
        return $this->morphMany(PayrollConceptAssignOption::class, 'assignable');
    }
}
