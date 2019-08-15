<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MaritalStatus as BaseMaritalStatus;

class MaritalStatus extends BaseMaritalStatus
{
    /**
     * Método que obtiene el estado civil asociado a muchas informaciones socioeconómicas del trabajador
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payroll_socioecomic_informations()
    {
        return $this->hasMany(PayrollSocioeconomicInformation::class);
    }
}
