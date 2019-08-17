<?php

namespace Modules\Payroll\Models;

use App\Models\Parish as BaseParish;

class Parish extends BaseParish
{
    /**
     * Método que obtiene la parroquia asociada a muchas informaciones personales del trabajador
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollStaffs()
    {
        return $this->hasMany(PayrollStaff::class);
    }
}
