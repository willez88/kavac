<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Department as BaseDepartment;

class Department extends BaseDepartment
{
    /**
     * Método que obtiene el departamento asociado a muchas informaciones laborales del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollEmploymentInformations()
    {
        return $this->hasMany(PayrollEmploymentInformation::class);
    }
}
