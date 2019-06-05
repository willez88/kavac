<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MaritalStatus as BaseMaritalStatus;

class MaritalStatus extends BaseMaritalStatus
{
    /**
     * MaritalStatus has many PayrollSocioeconomicInformation
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payroll_socioecomic_informations()
    {
    	return $this->hasMany(PayrollSocioeconomicInformation::class);
    }
}
