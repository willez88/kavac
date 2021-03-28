<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MaritalStatus as BaseMaritalStatus;

class MaritalStatus extends BaseMaritalStatus
{
    /**
     * Método que obtiene el estado civil asociado a muchas informaciones socioeconómicas del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollSocioecomicInformations()
    {
        return $this->hasMany(PayrollSocioeconomicInformation::class);
    }
}
