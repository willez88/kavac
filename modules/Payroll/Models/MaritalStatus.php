<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MaritalStatus as BaseMaritalStatus;

class MaritalStatus extends BaseMaritalStatus
{
    /**
     * Método que obtiene el estado civil relacionada a la información socioeconómica
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return object Objeto con los registros relacionados al modelo PayrollSocioeconomicInformation
     */
    public function payroll_socioecomic_informations()
    {
    	return $this->hasMany(PayrollSocioeconomicInformation::class);
    }
}
